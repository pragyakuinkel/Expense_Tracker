<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckCategoryUserDateRequest;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $left = 100 - User::where('id', Auth::id())
                ->first()
                ->categories()
                ->wherePivot('date', '>=', Carbon::parse($request->input('date'))->startOfMonth())
                ->wherePivot('date', '<=', Carbon::parse($request->input('date'))->endOfMonth())
                ->sum('limit');

        $error = session()->get('error');

        return view('category_user.create', compact('error', 'left'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckCategoryUserDateRequest $request)
    {
        $left = 100 - User::where('id', Auth::id())
                ->first()
                ->categories()
                ->wherePivot('date', '>=', Carbon::parse($request->input('date'))->startOfMonth())
                ->wherePivot('date', '<=', Carbon::parse($request->input('date'))->endOfMonth())
                ->sum('limit');

        if($request->limit > $left){

            if($left == 0){
                session()->flash('error', "You have no limit left.");
            }else{
                session()->flash('error', "Limit will go over 100%, please put limit below $left");
            }

            return back()->withInput();
        }

        DB::beginTransaction();

        try {
            $category = Category::withTrashed()->where('name', $request->name)->first();

            if ($category) {

                $category->restore();

                $category->users()->attach(Auth::id(), [
                    'limit' => $request->limit,
                    'date' => Carbon::parse($request->input('date'))->startOfMonth()->format('Y-m-d'),
                ]);
            } else {

                $category = Category::where('name', $request->name)->first();


                if ($category) {
                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::parse($request->input('date'))->startOfMonth()->format('Y-m-d'),
                    ]);
                } else {
                    $category = Category::create([
                        'name' => $request->name,
                        'user_id' => Auth::id(),
                    ]);

                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::parse($request->input('date'))->startOfMonth()->format('Y-m-d'),
                    ]);
                }
            }

            DB::commit();

            session()->flash('message', 'Category added successfully');

            return redirect()->route('category_user.monthlyCategory',['date'=>$request->input('date')]);

        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Category not added");

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $month)
    {

    }

    public function monthlyCategory(Request $request){

        $monthSelected = $request->input('date');

        $date = Carbon::parse($request->input('date'));

        $search = $request->input('search');

        $success = session()->get('success');;

        $categories = Auth::user()
            ->categories()
            ->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->where('name', 'LIKE', "%{$search}%")
            ->orderBy('created_at', 'desc')->paginate(10);

        $categories->appends(['date' => $request->input('date'),'search' => $search]);

        return view('category_user.monthlyCategory', compact('categories', 'success','monthSelected','date','search'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $error = session()->get('error');

        $date = $request->date;

        $category = User::where('id', Auth::id())
        ->first()
        ->categories()
        ->wherePivot('category_id', $id)
        ->wherePivot('date', '>=', Carbon::parse($request->date)->startOfMonth())
        ->wherePivot('date', '<=', Carbon::parse($request->date)->endOfMonth())->first();

        if($category == null){
            abort(404);
        }

        return view('category_user.edit', compact('category', 'error','date'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $left = 100 - User::where('id', Auth::id())
                ->first()
                ->categories()
                ->wherePivot('category_id', '!=', $id)
                ->wherePivot('date', '>=', Carbon::parse($request->date)->startOfMonth())
                ->wherePivot('date', '<=', Carbon::parse($request->date)->endOfMonth())
                ->sum('limit');

        if($request->limit > $left){
            session()->flash('error', "Limit will go over 100%, please put limit below $left");

            return back()->withInput();
        }

        DB::beginTransaction();

        try{
            $oldCategory = Category::where('id', $id)->first();

            $oldCategory->users()
                ->where('user_id', Auth::id())
                ->wherePivot('date', '>=', Carbon::parse($request->date)->startOfMonth())
                ->wherePivot('date', '<=', Carbon::parse($request->date)->endOfMonth())
                ->detach();

            $category = Category::where('name', $request->name)->first();

            if ($category) {
                $category->users()->attach(Auth::id(), [
                    'limit' => $request->limit,
                    'date' => Carbon::parse($request->date)->startOfMonth(),
                ]);
            }else {

                $category = Category::withTrashed()->where('name', $request->name)->first();

                if ($category) {

                    $category->restore();

                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::parse($request->date)->startOfMonth(),
                    ]);

                } else {

                    $category = Category::where('name', $request->name)->first();

                    if ($category) {
                        $category->users()->attach(Auth::id(), [
                            'limit' => $request->limit,
                            'date' => Carbon::parse($request->date)->startOfMonth()
                        ]);
                    } else {
                        $category = Category::create([
                            'name' => $request->name,
                            'user_id' => Auth::id(),
                        ]);

                        $category->users()->attach(Auth::id(), [
                            'limit' => $request->limit,
                            'date' => Carbon::parse($request->date)->startOfMonth(),
                        ]);
                    }
                }
            }

            DB::commit();

            session()->flash('success', 'Category added successfully');

            return redirect()->route('category_user.monthlyCategory');

        }catch (\Exception $exception){
            DB::rollBack();

            session()->flash('error', $exception->getMessage());

            return redirect()->back();
        }
    }

    public function delete(Category $category, string $date = null)
    {
        return view('category_user.delete', compact('category','date'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->users()
                ->where('user_id', Auth::id())
                ->wherePivot('date', '>=', Carbon::parse($request->date)->startOfMonth())
                ->wherePivot('date', '<=', Carbon::parse($request->date)->endOfMonth())
                ->detach();

            session()->flash('success', 'Category deleted successfully');

            return redirect()->route('category_user.monthlyCategory', ['date' => $request->date]);
        } catch (\Exception $exception) {

            session()->flash('error', "Category not deleted");

            return back();
        }
    }
}

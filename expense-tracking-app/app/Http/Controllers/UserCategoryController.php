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
    public function create()
    {
        $left = 100 - User::where('id', Auth::id())->first()->categories()->sum('limit');

        $error = session()->get('error');

        return view('category_user.create', compact('error', 'left'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckCategoryUserDateRequest $request)
    {
        $left = 100 - User::where('id', Auth::id())->first()->categories()->sum('limit');

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
                    'date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                ]);
            } else {

                $category = Category::where('name', $request->name)->first();


                if ($category) {
                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                    ]);
                } else {
                    $category = Category::create([
                        'name' => $request->name,
                        'user_id' => Auth::id(),
                    ]);

                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                    ]);
                }
            }

            DB::commit();

            session()->flash('message', 'Category added successfully');

            return redirect()->route('category_user.monthlyCategory');

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

        $success = session()->get('success');;

        $categories = Auth::user()
            ->categories()
            ->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->orderBy('created_at', 'desc')->get();

        return view('category_user.monthlyCategory', compact('categories', 'success','monthSelected','date'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $error = session()->get('error');

        $category = Category::find($id);

        foreach($category->users as $user){
            $limit = $user->pivot->limit;
        }

        return view('category_user.edit', compact('category', 'error','limit'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $left = 100 - User::where('id', Auth::id())->first()->categories()->sum('limit');

        if($request->limit > $left){
            session()->flash('error', "Limit will go over 100%, please put limit below $left");

            return back()->withInput();
        }

        DB::beginTransaction();

        try{
            $category = Category::where('name', $request->name)->first();

            if ($category) {
                $category->users()
                    ->where('user_id', Auth::id())
                    ->wherePivot('date', '>=', Carbon::now()->startOfMonth())
                    ->wherePivot('date', '<=', Carbon::now()->endOfMonth())
                    ->update(['limit' => $request->limit]);
            }else{
                $category=Category::create([
                    'name'=>$request->name,
                    'role_id'=>2,
                ]);

                $category->users()
                    ->where('user_id', Auth::id())
                    ->wherePivot('date', '>=', Carbon::now()->startOfMonth())
                    ->wherePivot('date', '<=', Carbon::now()->endOfMonth())
                    ->update(['limit' => $request->limit]);

                $category->users()->attach(Auth::id(), ['limit'=>$request->limit,'date'=>Carbon::now()->format('Y-m-d')]);
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

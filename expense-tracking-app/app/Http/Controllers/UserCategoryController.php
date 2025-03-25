<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckCategoryUserDateRequest;
use App\Models\Category;
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
        $categories = Auth::user()
            ->categories()
            ->orderBy('created_at', 'desc')->get()->groupBy(function ($category) {
                return Carbon::parse($category->pivot->date)->format('Y F');
            });


        $success = session()->get('success');

        return view('category_user.index', compact('categories', 'success'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $error = session()->get('error');

        return view('category_user.create', compact('error'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckCategoryUserDateRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = Category::withTrashed()->where('name', $request->name)->first();

            if ($category) {
                $category->restore();

                $category->users()->attach(Auth::id(), [
                    'limit' => $request->limit,
                    'date' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                $category = Category::where('name', $request->name)->first();


                if ($category) {
                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::now()->format('Y-m-d'),
                    ]);
                } else {
                    $category = Category::create([
                        'name' => $request->name,
                        'user_id' => Auth::id(),
                    ]);

                    $category->users()->attach(Auth::id(), [
                        'limit' => $request->limit,
                        'date' => Carbon::now()->format('Y-m-d'),
                    ]);
                }
            }

            DB::commit();

            session()->flash('message', 'Category added successfully');

            return redirect()->route('category_user.index');

        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Category not added");

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $error = session()->get('error');

        $category = Category::find($id);

        if ($category) {
            return view('category_user.edit', compact('category', 'error'));
        } else {
            return redirect()->route('category_user.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        DB::beginTransaction();
//
//        try{
//            $category = Category::where('name', $request->name)->first();
//
//            if ($category) {
//                $category->users()
//                    ->where('user_id', Auth::id())
//                    ->wherePivot('date', '>=', Carbon::now()->startOfMonth())
//                    ->wherePivot('date', '<=', Carbon::now()->endOfMonth())
//                    ->update(['limit' => $request->limit]);
//            }else{
//                $category=Category::create([
//                    'name'=>$request->name,
//                    'role_id'=>2,
//                ]);

//                $category->users()
//                    ->where('user_id', Auth::id())
//                    ->wherePivot('date', '>=', Carbon::now()->startOfMonth())
//                    ->wherePivot('date', '<=', Carbon::now()->endOfMonth())
//                    ->update(['limit' => $request->limit]);

//                $category->users()->attach(Auth::id(), ['limit'=>$request->limit,'date'=>Carbon::now()->format('Y-m-d')]);
//            }
//            DB::commit();
//
//            session()->flash('success', 'Category added successfully');
//
//            return redirect()->route('category_user.index');
//
//        }catch (\Exception $exception){
//            DB::rollBack();
//
//            session()->flash('error', $exception->getMessage());
//
//            return redirect()->back();
//        }
    }

    public function delete(Category $category)
    {
        return view('category_user.delete', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        try {
            $category->users()
                ->where('user_id', Auth::id())
                ->wherePivot('date', '>=', Carbon::now()->startOfMonth())
                ->wherePivot('date', '<=', Carbon::now()->endOfMonth())
                ->detach();

            session()->flash('success', 'Category deleted successfully');

            return redirect()->route('category_user.index');
        } catch (\Exception $exception) {

            session()->flash('error', "Category not deleted");

            return back();
        }
    }
}

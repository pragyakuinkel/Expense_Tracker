<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $success=session()->get('success');

        $categories = Category::with('user')
            ->leftJoin('category_user', 'categories.id', '=', 'category_user.category_id')
            ->leftJoin('users', 'category_user.user_id', '=', 'users.id')
            ->select('categories.id as id','categories.name','categories.user_id','users.name as username', DB::raw('COUNT(DISTINCT category_user.user_id) as users_count'))
            ->groupBy('categories.id','categories.name','categories.user_id','users.name')
            ->get();

        return view('category.index', compact('categories', 'success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category=Category::withTrashed()->where('name',$request->name)->first();

        if($category != null){
            $category->restore();
        }else{

            Category::create([
                'name'=>$request->name,
                'user_id'=>Auth::user()->id
            ]);
        }

        session()->flash('success', 'Category created successfully');

        return redirect()->route('category.index');
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
    public function edit(Category $category)
    {
        $category=Category::find($category->id);

        if($category){
            return view('category.edit', compact('category'));
        }else{
            return redirect()->route('category.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $category=Category::find($category->id);
        if($category){
            $category->update([
                'name'=>$request->name
            ]);
            session()->flash('success', 'Category updated successfully');
            return redirect()->route('category.index');
        }else{
            return redirect()->route('category.index');
        }
    }

    public function delete(Category $category){

        $category=Category::where('id',$category->id)->first();

        if($category != null){
            return view('category.delete', compact('category'));
        }else{
            return redirect()->route('category.index');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category=Category::find($category->id);

        if($category){
            $category->delete();

            session()->flash('success', 'Category deleted successfully');

            return redirect()->route('category.index');
        }else{
            return redirect()->route('category.index');
        }
    }
}

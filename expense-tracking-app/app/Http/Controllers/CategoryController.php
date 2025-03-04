<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $success=session()->get('success');

        if(Auth::user()->roles()->first()->name === 'superAdmin'){
            $categories = Category::orderBy('id','desc')->paginate(10);
        }

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
        Category::create([
            'name'=>$request->name,
            'role_id'=>Auth::user()->roles()->first()->id
        ]);

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

        $category=Category::find($category->id);

        if($category){
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

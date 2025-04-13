<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $start_date = $request->input('start_date') ?? Carbon::now()->startOfMonth();

        $end_date = $request->input('end_date') ?? Carbon::now()->endOfMonth();

        $date = Carbon::parse($start_date)->format('d M Y') .' - '.Carbon::parse($end_date)->format('d M Y') ?? "";

        $search = $request->input('search');

        $success = session()->get('success');

        $categories = Category::with('user')
            ->leftJoin('category_user', 'categories.id', '=', 'category_user.category_id')
            ->leftJoin('users', 'category_user.user_id', '=', 'users.id')

            ->whereBetween('categories.created_at', [$start_date, $end_date])
            ->where(function ($query) use ($search, $request) {
                $query->where('categories.name','like',"%{$search}%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name','like',"%{$search}%")
                        ->orWhere('username','like',"%{$search}%");
                });
            })
            ->select('categories.id as id', 'categories.name','categories.updated_at','categories.user_id', 'users.name as username', DB::raw('COUNT(DISTINCT category_user.user_id) as users_count'))
            ->groupBy('categories.id','categories.name','categories.updated_at', 'categories.user_id', 'users.name')
            ->orderBy('categories.updated_at', 'desc')
            ->paginate(10);

        $categories->appends(['start_date' => $request->input('start_date'),'end_date' => $request->input('end_date'),'search' => $search]);

        return view('category.index', compact('categories', 'success','search','date'));
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
        $category = Category::withTrashed()->where('name', $request->name)->first();

        if ($category != null) {
            $category->restore();
        } else {

            Category::create([
                'name' => $request->name,
                'user_id' => Auth::user()->id
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
        if($category->users()->count() > 0 || $category->expenses()->count() > 0 ){
            return redirect()->route('category.editCategoryConfirmation',$category);
        }else{
            return view('category.edit', compact('category'));
        }
    }

    public function confirmation(Category $category){
        return view('category.confirmation', compact('category'));
    }

    public function confirm(Category $category){
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {

        $category->update([
            'name' => $request->name
        ]);

        session()->flash('success', 'Category updated successfully');

        return redirect()->route('category.index');

    }

    public function delete(Category $category)
    {

        return view('category.delete', compact('category'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);

        if ($category) {
            $category->delete();

            session()->flash('success', 'Category deleted successfully');

            return redirect()->route('category.index');
        } else {
            return redirect()->route('category.index');
        }
    }
}

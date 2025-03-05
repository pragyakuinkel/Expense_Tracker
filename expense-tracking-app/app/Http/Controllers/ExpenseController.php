<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
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
        $categories=Category::whereHas('users', function($q){
            $q->where('user_id', auth()->id())
                ->whereMonth('date', '=', Carbon::now());
        })->get();
        $current=Carbon::now()->format('Y-m-d');
        return view('expense.create', compact('categories','current'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        Expense::create([
            'description'=>$request->description,
            'amount'=>$request->amount,
            'category_id'=>$request->category,
            'user_id'=>auth()->id(),
            'date'=>$request->date
        ]);

        session()->flash('success', 'Expense added successfully');

        return redirect(route('dashboard'));
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
    public function edit(Expense $expense)
    {
        $expense=Expense::find($expense->id);

        $categories=Category::whereHas('users', function($q){
            $q->where('user_id', auth()->id())
                ->whereMonth('date', '=', Carbon::now());
        })->get();

        return view('expense.edit', compact('expense','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense=Expense::find($expense->id);

        $expense->update([
            'description'=>$request->description,
            'amount'=>$request->amount,
            'category_id'=>$request->category,
            'date'=>$request->date
        ]);

        session()->flash('success', 'Expense updated successfully');

        return redirect(route('dashboard'));
    }

    public function delete(Expense $expense){

        $expense=Expense::find($expense->id);

        if($expense){
            return view('expense.delete', compact('expense'));
        }else{
            return redirect(route('dashboard'));
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense=Expense::find($expense->id);

        if($expense){
            $expense->delete();

            session()->flash('success', 'Expense deleted successfully');

            return redirect(route('dashboard'));
        }else{
            return redirect(route('dashboard'));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\Action;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try{
            $expense = Expense::create([
                'description'=>$request->description,
                'amount'=>$request->amount,
                'category_id'=>$request->category,
                'user_id'=>auth()->id(),
                'date'=>$request->date
            ]);

            Statement::create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'statementable_id' => $expense->id,
                'statementable_type' => 'expense',
                'action' => Action::Add
            ]);

            DB::commit();

            session()->flash('success', 'Expense added successfully');

            return redirect(route('dashboard'));
        }catch (\Exception $exception){
            DB::rollBack();
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
    public function edit(Expense $expense)
    {
        $expense=Expense::find($expense->id);

        if($expense->user_id !== Auth::id()){
            abort(401);
        }

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
        DB::beginTransaction();

        try{
            $expense=Expense::find($expense->id);

            $expense->update([
                'description'=>$request->description,
                'amount'=>$request->amount,
                'category_id'=>$request->category,
                'date'=>$request->date
            ]);

            Statement::create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'statementable_id' => $expense->id,
                'statementable_type' => 'expense',
                'action' => Action::Add
            ]);

            DB::commit();

            session()->flash('success', 'Expense updated successfully');

            return redirect(route('dashboard'));
        }catch (\Exception $exception){
            DB::rollBack();
        }



    }

    public function delete(Expense $expense){

        if($expense->user_id !== Auth::id()){
            abort(401);
        }

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
        DB::beginTransaction();

        try{
            $expense=Expense::find($expense->id);

            Statement::create([
                'amount' => $expense->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::parse($expense->date)->format('Y-m-d'),
                'statementable_id' => $expense->id,
                'statementable_type' => 'expense',
                'action' => Action::Delete
            ]);

            if($expense){
                $expense->delete();

                DB::commit();

                session()->flash('success', 'Expense deleted successfully');

                return redirect(route('dashboard'));
            }else{
                return redirect(route('dashboard'));
            }
        }catch (\Exception $exception){
            DB::rollBack();
        }

    }
}

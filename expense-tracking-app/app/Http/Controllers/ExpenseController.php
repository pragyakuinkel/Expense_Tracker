<?php

namespace App\Http\Controllers;

use App\Enum\Action;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\FilterRequest;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $search = $request->input('search');

        $start_date = $request->input('start_date') ?? Carbon::now()->startOfMonth();

        $end_date = $request->input('end_date') ?? Carbon::now()->endOfMonth();

        $date = Carbon::parse($start_date)->format('d M Y') .' - '.Carbon::parse($end_date)->format('d M Y') ;

        $expenses = Expense::where('user_id', Auth::id())
                ->whereBetween('date', [$start_date, $end_date])
                ->where(function ($query) use ($request) {
                    $query->where('description','like',"%{$request->search}%")
                        ->orWhere('date','like',"%{$request->search}%")
                        ->orWhere('amount','like',"%{$request->search}%")->OrWhereHas('category', function ($query) use ($request) {
                            $query->where('name','like',"%{$request->search}%");
                        });
                })
                ->orderBy('date', 'desc')
                ->paginate(10);

        $expenses->appends(['search' => $search,'start_date' => $request->input('start_date'),'end_date' => $request->input('end_date')]);

        return view('expense.index', compact('expenses', 'date','search'));
    }
    public function search(Request $request){


        $date = ' / '.$request->search;

        $expenses = Expense::where('user_id', Auth::id())
            ->where('description','like',"%{$request->search}%")
            ->orWhere('date','like',"%{$request->search}%")
            ->orWhere('amount','like',"%{$request->search}%")
            ->OrWhereHas('category', function ($query) use ($request) {
                $query->where('name','like',"%{$request->search}%");
            })
            ->paginate(10);

        return view('expense.index', compact('expenses', 'date'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereHas('users', function ($q) {
            $q->where('user_id', auth()->id())
                ->whereMonth('date', '=', Carbon::now())
                ->whereYear('date', '=', Carbon::now());
        })->get();

        $current = Carbon::now()->format('Y-m-d');

        return view('expense.create', compact('categories', 'current'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        DB::beginTransaction();
        try {
            $expense = Expense::create([
                'description' => $request->description,
                'amount' => $request->amount,
                'category_id' => $request->category,
                'user_id' => auth()->id(),
                'date' => $request->date
            ]);

            $expense->logs()->create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'action' => Action::Add
            ]);

            DB::commit();

            session()->flash('success', 'Expense added successfully');

            return redirect(route('expense.index'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error',
                "Expense not added"
            );

            return back();
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

        if (! Gate::allows('update-expense', $expense)) {
            abort(403);
        }

        $user_selected_category = $expense->category;

        $categories = Category::whereHas('users', function ($q) use ($expense) {
            $q->where('user_id', auth()->id())
                ->whereMonth('date', '=',  Carbon::parse($expense->date))
                ->whereYear('date', '=', Carbon::parse($expense->date));
        })->get();

        $categories = $categories->merge(collect([$user_selected_category]))->unique('id');

        return view('expense.edit', compact('expense', 'categories','user_selected_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        DB::beginTransaction();

        try {

            $expense->update([
                'description' => $request->description,
                'amount' => $request->amount,
                'category_id' => $request->category,
                'date' => $request->date
            ]);

            $expense->logs()->create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'action' => Action::Update
            ]);

            DB::commit();

            session()->flash('success', 'Expense updated successfully');

            return redirect(route('expense.index'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Expense not updated");

            return back();
        }


    }

    public function delete(string $expense)
    {
        $expense = Expense::findOrFail($expense);

        if ($expense->user_id !== Auth::id()) {
            abort(401);
        }

        return view('expense.delete', compact('expense'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        DB::beginTransaction();

        try {

            $expense->delete();

            $expense->logs()->create([
                'amount' => $expense->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'action' => Action::Delete
            ]);

            DB::commit();

            session()->flash('success', 'Expense deleted successfully');

            return redirect(route('expense.index'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Expense not deleted");

            return back();
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\Action;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\IncomeRequest;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $start_date = $request->input('start_date') ?? Carbon::now()->startOfMonth();

        $end_date = $request->input('end_date') ?? Carbon::now()->endOfMonth();

        $date = Carbon::parse($start_date)->format('d M Y') .' - '.Carbon::parse($end_date)->format('d M Y') ;

        $incomes = Income::where('user_id', Auth::id())
            ->whereBetween('date', [$start_date, $end_date])
            ->where(function ($query) use ($request) {
                $query->where('description','like',"%{$request->search}%")
                    ->orWhere('date','like',"%{$request->search}%");
            })
            ->orderBy('date', 'desc')
            ->paginate(10);

        $search = $request->input('search') ?? "";

        $incomes->appends(['search' => $search,'start_date' => $request->input('start_date'),'end_date' => $request->input('end_date')]);

        return view('income.index', compact('incomes', 'date','search'));
    }
    public function search(Request $request){


        $date = ' / '.$request->search;

        $incomes = Income::where('user_id', Auth::id())
            ->where('description','like',"%{$request->search}%")
            ->orWhere('date','like',"%{$request->search}%")
            ->orWhere('amount','like',"%{$request->search}%")
            ->paginate(10);

        return view('income.index', compact('incomes', 'date'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $current = Carbon::now()->format('Y-m-d');
        return view('income.create', compact('current'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeRequest $request)
    {
        DB::beginTransaction();

        try {
            $income = Income::create([
                'description' => $request->description,
                'amount' => $request->amount,
                'user_id' => auth()->id(),
                'date' => $request->date
            ]);

            $income->logs()->create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'action' => Action::Add
            ]);

            DB::commit();

            session()->flash('success', 'Income added successfully');

            return redirect(route('income.index'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error',
$exception->getMessage()
//                "Income not added"
            );

            return back()->withInput();
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
    public function edit(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(401);
        }

        return view('income.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeRequest $request, income $income)
    {
        DB::beginTransaction();

        try {

            $income->update([
                'description' => $request->description,
                'amount' => $request->amount,
                'date' => $request->date
            ]);

            $income->logs()->create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'action' => Action::Update
            ]);

            DB::commit();

            session()->flash('success', 'Expense updated successfully');

            return redirect(route('dashboard'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Income not updated");

            return back();
        }
    }

    public function delete(string $income)
    {
        $income = Income::findOrFail($income);

        if ($income->user_id !== Auth::id()) {
            abort(401);
        }

        return view('income.delete', compact('income'));

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        DB::beginTransaction();

        try {
            $income = Income::findOrFail($income->id);

            if ($income) {
                $income->delete();

                $income->logs()->create([
                    'amount' => $income->amount,
                    'user_id' => Auth::id(),
                    'date' => Carbon::now()->format('Y-m-d'),
                    'action' => Action::Delete
                ]);

                DB::commit();

                session()->flash('success', 'Income deleted successfully');

                return redirect(route('income.index'));
            } else {
                return redirect(route('income.index'));
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Income not deleted");

            return back();
        }

    }
}

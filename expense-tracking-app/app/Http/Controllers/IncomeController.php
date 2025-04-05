<?php

namespace App\Http\Controllers;

use App\Enum\Action;
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
    public function index(Request $request)
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

        return view('income.index', compact('incomes', 'date','search'));
    }

//    public function filter(Request $request)
//    {
//        $date = ' / '.  Carbon::parse($request->start_date)->format('d M Y') .' - '.Carbon::parse($request->end_date)->format('d M Y') ;
//        $incomes = Income::where('user_id', Auth::id())
//            ->whereBetween('date', [$request->start_date, $request->end_date])
//            ->orderBy('date', 'desc')->paginate(10);
//
//        return view('income.index', compact('incomes', 'date'));
//    }

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

            Log::create([
                'amount' => $income->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'logable_id' => $income->id,
                'logable_type' => 'income',
                'action' => Action::Add
            ]);

            DB::commit();

            session()->flash('success', 'Income added successfully');

            return redirect(route('dashboard'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Income not added");

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
    public function edit(Income $income)
    {
        $income = Income::findOrFail($income->id);

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
            ]);

            Log::create([
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'logable_id' => $income->id,
                'logable_type' => 'income',
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
        //first tries to find data of that id if not found throws ModelNotFoundException which if not done in a try catch block creates a 404 response
        $income = Income::findOrFail($income);

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

                Log::create([
                    'amount' => $income->amount,
                    'user_id' => Auth::id(),
                    'date' => Carbon::now()->format('Y-m-d'),
                    'logable_id' => $income->id,
                    'logable_type' => 'income',
                    'action' => Action::Delete
                ]);

                DB::commit();

                session()->flash('success', 'Income deleted successfully');

                return redirect(route('dashboard'));
            } else {
                return redirect(route('dashboard'));
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error', "Income not deleted");

            dd($exception->getMessage());
            return back();
        }

    }
}

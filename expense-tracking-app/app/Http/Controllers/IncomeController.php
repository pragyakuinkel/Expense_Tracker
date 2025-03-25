<?php

namespace App\Http\Controllers;

use App\Enum\Action;
use App\Http\Requests\IncomeRequest;
use App\Models\Income;
use App\Models\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

            Statement::create([
                'amount' => $income->amount,
                'user_id' => Auth::id(),
                'date' => Carbon::parse($income->date)->format('Y-m-d'),
                'statementable_id' => $income->id,
                'statementable_type' => 'income',
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

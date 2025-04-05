<?php

namespace App\Http\Controllers;

use App\Enum\Action;
use App\Http\Requests\EstimateRequest;
use App\Models\Category;
use App\Models\Estimate;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstimateController extends Controller
{
    public function income()
    {
        return view('estimate.income');
    }

//    public function editIncome($date)
//    {
//        $date = Carbon::parse($date);
//
//        $estimate = Estimate::where('user_id', Auth::id())->whereMonth('date', $date->month)
//            ->whereYear('date', $date->year)->first();
//
//        return view('estimate.edit-income', compact('estimate', 'date'));
//    }

    public function storeIncome(Request $request)
    {
        DB::beginTransaction();

        try {

            if ($request->type == 'monthly') {
                $amount = $request->amount;
            } else {
                $amount = $request->amount / 12;
            }

            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            foreach ($month as $m) {

                $date = date_parse(Carbon::now()->year . " " . $m);;

                $estimate_created = Estimate::create([
                    'amount' => $amount,
                    'user_id' => Auth::id(),
                    'date' => $date['year'] . '-' . $date['month'] . '-' . $date['day'],
                ]);

                Log::create([
                    'amount' => $amount,
                    'user_id' => Auth::id(),
                    'date' => $date['year'] . '-' . $date['month'] . '-' . $date['day'],
                    'logable_id' => $estimate_created->id,
                    'logable_type' => '',
                    'action' => Action::Add
                ]);

            }

            DB::commit();

            return redirect()->route('dashboard');

        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('error',
                'Estimate failed to save.'
        );

            return redirect()->back();
        }
    }

//    public function updateIncome(EstimateRequest $request, Estimate $estimate)
//    {
//
//        if ($estimate) {
//            DB::beginTransaction();
//
//            try {
//                $estimate->update([
//                    'amount' => $request->amount
//                ]);
//
//                Log::create([
//                    'amount' => $request->amount,
//                    'user_id' => Auth::id(),
//                    'date' => Carbon::parse($estimate->date)->format('Y-m-d'),
//                    'logable_id' => $estimate->id,
//                    'logable_type' => 'expense',
//                    'action' => Action::Update
//                ]);
//
//                DB::commit();
//
//                session()->flash('success', 'Estimate updated successfully');
//
//                return redirect()->route('forecast.forecast');
//            } catch (\Exception $exception) {
//                DB::rollBack();
//
//                session()->flash('error', 'Estimate failed to update.');
//
//                return redirect()->back();
//            }
//        } else {
//            return back();
//        }
//    }

    public function selectCategory()
    {
        $error = session()->get('error');

        $categories = Category::where('user_id', 1)->get();

        return view('estimate.selectCategory', compact('categories', 'error'));
    }

    public function showLimit(Request $request)
    {
        if ($request->categories == null && $request->new_categories == null) {

            session()->flash('error', 'Please select a category');

            return back();
        }

        $categories = $request->categories;

        $new_categories = $request->new_categories;

        if ($categories == null) {
            $categories = [];
        } elseif ($new_categories == null) {
            $new_categories = [];
        }

        return view('estimate.addLimit', compact('categories', 'new_categories'));
    }

    public function storeLimit(Request $request)
    {
        DB::beginTransaction();

        try {

            $totalLimit = 0;

            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            if ($request->categories == null) {
                $categories = [];
            } else {
                $categories = $request->categories;
            }

            if ($request->new_categories == null) {
                $new_categories = [];
            } else {
                $new_categories = $request->new_categories;
            }

            for ($i = 0; $i < count($categories); $i++) {
                $category = Category::where('name', $categories[$i])->first();

                if ($category) {
                    foreach ($month as $m) {
                        $date = date_parse(Carbon::now()->year . " " . $m);

                        if (Carbon::now()->format('m') == $date['month']) {
                            $limit = $request->limits[$i];
                            $totalLimit += $limit;
                        } else {
                            $limit = 0;
                        }

                        $category->users()->attach(Auth::id(), [
                            'limit' => $limit,
                            'date' => $date['year'] . '-' . $date['month'] . '-' . $date['day'],
                        ]);
                    }
                }
            }

            for ($i = 0; $i < count($new_categories); $i++) {
                $category = Category::where('name', $new_categories[$i])->first();

                if ($category) {
                    foreach ($month as $m) {
                        $date = date_parse(Carbon::now()->year . " " . $m);

                        if (Carbon::now()->format('m') === $date['month']) {
                            $limit = $request->new_limits[$i];
                            $totalLimit += $limit;
                        } else {
                            $limit = 0;
                        }

                        $category->users()->attach(Auth::id(), [
                            'limit' => $limit,
                            'date' => $date['year'] . '-' . $date['month'] . '-' . $date['day'],
                        ]);
                    }
                } else {
                    $newCategory = Category::create(['name' => $new_categories[$i], 'user_id' => Auth::id()]);

                    foreach ($month as $m) {
                        $date = date_parse(Carbon::now()->year . " " . $m);

                        if (Carbon::now()->format('m') === $date['month']) {
                            $limit = $request->new_limits[$i];
                            $totalLimit += $limit;
                        } else {
                            $limit = 0;
                        }

                        $newCategory->users()->attach(Auth::id(), [
                            'limit' => $limit,
                            'date' => $date['year'] . '-' . $date['month'] . '-' . $date['day'],
                        ]);
                    }
                }
            }

            if($totalLimit > 100){

                session()->flash('error',
                    'Expense limit exceeded.'
                );

                return view('estimate.addLimit', compact('categories', 'new_categories'));
            }

            DB::commit();

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error',
                'Category failed to save.'
            );

            return redirect()->route('estimate.selectCategory');
        }
    }

}

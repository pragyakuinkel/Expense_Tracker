<?php

namespace App\Http\Controllers;

use App\Enum\Action;
use App\Enum\RoleName;
use App\Models\Category;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstimateController extends Controller
{
    public function income()
    {
        $estimate = Estimate::where('user_id', Auth::id())
            ->whereYear('date', Carbon::now()->year)
            ->first();

        if ($estimate) {
            return abort(404);
        }

        return view('estimate.income');
    }

    public function storeIncome(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);


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

                $estimate_created->logs()->create([
                    'amount' => $amount,
                    'user_id' => Auth::id(),
                    'date' => Carbon::now()->format('Y-m-d'),
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

    public function selectCategory()
    {

        $categories = Category::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id())->whereYear('date',Carbon::now()->year);
        })->exists();

        if ($categories) {
            return abort(404);
        }

        $error = session()->get('error');

        $categories = Category::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($q) {
                $q->where('name', RoleName::ADMIN);
            });
        })->get();



        return view('estimate.selectCategory', compact('categories', 'error'));
    }

    public function showLimit(Request $request)
    {
        $categories = Category::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id())->whereYear('date',Carbon::now()->year);
        })->exists();

        if ($categories) {
            return abort(404);
        }

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
        $categories = Category::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id())->whereYear('date',Carbon::now()->year);
        })->exists();

        if ($categories) {
            return abort(404);
        }

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

                        if($limit < 0){

                            session()->flash('error',
                                'Limit less than 0.'
                            );

                            return view('estimate.addLimit', compact('categories', 'new_categories'));
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

                        if($limit < 0){

                            session()->flash('error',
                                'Limit less than 0.'
                            );

                            return view('estimate.addLimit', compact('categories', 'new_categories'));
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

                        if($limit < 0){

                            session()->flash('error',
                                'Limit less than 0.'
                            );

                            return view('estimate.addLimit', compact('categories', 'new_categories'));
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

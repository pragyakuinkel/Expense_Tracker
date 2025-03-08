<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\IncomeRequest;
use App\Models\Category;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class EstimateController extends Controller
{
    public function income(){
        return view('estimate.income');
    }

    public function editIncome($month){

        $date=Carbon::parse($month);

        $estimate=Estimate::where('user_id', Auth::id())->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)->first();

        return view('estimate.edit-income', compact('estimate','month'));
    }
    public function storeIncome(IncomeRequest $request){

        if($request->type == 'monthly'){
            $amount=$request->amount;
        }else{
            $amount=$request->amount/12;
        }

        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        foreach ($month as $m) {
            Estimate::create([
                'amount'=>$amount,
                'user_id'=>Auth::id(),
                'date'=>Carbon::parse($m)->format('Y-m-d')
            ]);
        }

        return redirect()->route('dashboard');

    }

    public function updateIncome(IncomeRequest $request,Estimate $estimate)
    {

        if($estimate){
            $estimate->update([
                'amount'=>$request->amount
            ]);

            session()->flash('success', 'Estimate updated successfully');

            return redirect()->route('forecast.forecast');
        }else{
            return back();
        }
    }
    public function selectCategory()
    {
        $error= session()->get('error');
        $categories=Category::where('role_id',1)->get();

        return view('estimate.selectCategory',compact('categories','error'));
    }

    public function showLimit(Request $request)
    {
        if($request->categories == null && $request->new_categories == null){

            session()->flash('error','Please select a category');

            return back();
        }

        $categories=$request->categories;

        $new_categories=$request->new_categories;

        if ($categories == null) {
            $categories = [];
        }elseif ($new_categories == null) {
            $new_categories = [];
        }

        return view('estimate.addLimit',compact('categories','new_categories'));
    }

    public function storeLimit(Request $request)
    {
        DB::beginTransaction();

        try {
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
                        $date = Carbon::parse($m)->startOfMonth()->format('Y-m-d');

                        if(Carbon::now()->format('F') === $m){
                            $limit = $request->limits[$i];
                        }else{
                            $limit=0;
                        }

                        $category->users()->attach(Auth::id(), [
                            'limit' => $limit,
                            'date' => $date
                        ]);
                    }
                }
            }

            for ($i = 0; $i < count($new_categories); $i++) {
                $category = Category::where('name', $new_categories[$i])->first();

                if ($category) {
                    foreach ($month as $m) {
                        $date = Carbon::parse($m)->startOfMonth()->format('Y-m-d');

                        if(Carbon::now()->format('F') === $m){
                            $limit = $request->new_limits[$i];
                        }else{
                            $limit=0;
                        }

                        $category->users()->attach(Auth::id(), [
                            'limit' => $limit,
                            'date' => $date
                        ]);
                    }
                } else {
                    $newCategory = Category::create(['name' => $new_categories[$i],'role_id'=>2]);

                    foreach ($month as $m) {
                        $date = Carbon::parse($m)->startOfMonth()->format('Y-m-d');

                        if(Carbon::now()->format('F') === $m){
                            $limit = $request->new_limits[$i];
                        }else{
                            $limit=0;
                        }

                        $newCategory->users()->attach(Auth::id(), [
                            'limit' => $limit,
                            'date' => $date
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('dashboard');
        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash('error', $e->getMessage());

            return redirect()->route('selectCategory');
        }
    }

}

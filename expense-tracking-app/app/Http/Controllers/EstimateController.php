<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Models\Category;
use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstimateController extends Controller
{
    public function income(){
        return view('estimate.income');
    }

    public function storeIncome(IncomeRequest $request){

        if($request->type == 'monthly'){
            $amount=$request->amount;
        }else{
            $amount=$request->amount/12;
        }

        Estimate::create([
            'amount'=>$amount,
            'user_id'=>Auth::id()
        ]);

        return redirect()->route('dashboard')->with('success','Estimate created successfully');

    }

    public function selectCategory()
    {
        $categories=Category::where('role_id',1)->get();

        return view('estimate.selectCategory',compact('categories'));
    }

}

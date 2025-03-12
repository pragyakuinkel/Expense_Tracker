<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified','admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('/category', CategoryController::class);

    Route::get('/category/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');

});

Route::middleware('auth')->group(function () {
    Route::get('/estimate/income',[EstimateController::class, 'income'])->name('estimate.income');

    Route::post('/addIncome',[EstimateController::class, 'storeIncome'])->name('addIncome');
});

Route::middleware(['auth','income'])->group(function(){

    Route::get('/selectCategory',[EstimateController::class, 'selectCategory'])->name('selectCategory');

    Route::post('/addCategory',[EstimateController::class, 'showLimit'])->name('addCategory');

    Route::post('/addLimit',[EstimateController::class, 'storeLimit'])->name('addLimit');
});

Route::middleware(['auth','income','category'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/category_user', UserCategoryController::class);

    Route::get('category_user/delete/{category}', [UserCategoryController::class, 'delete'])->name('category_user.delete');

    Route::get('/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');

    Route::resource('expense', ExpenseController::class);

    Route::get('/expense/delete/{expense}', [ExpenseController::class, 'delete'])->name('expense.delete');

    Route::get('/forecast/forecast/{date?}',[ForecastController::class, 'forecast'])->name('forecast.forecast');

    Route::get('/editIncome/{date}',[EstimateController::class, 'editIncome'])->name('editIncome');

    Route::put('updateIncome/{estimate}', [EstimateController::class, 'updateIncome'])->name('updateIncome');

    Route::resource('income', IncomeController::class);
});

require __DIR__.'/auth.php';

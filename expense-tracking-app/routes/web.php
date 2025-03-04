<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::resource('/category', CategoryController::class);

Route::get('/category/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');

Route::get('/estimate/income',[EstimateController::class, 'income'])->name('estimate.income');

Route::post('/addIncome',[EstimateController::class, 'storeIncome'])->name('addIncome');

Route::get('/selectCategory',[EstimateController::class, 'selectCategory'])->name('selectCategory');

Route::middleware('auth','income','category')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});
require __DIR__.'/auth.php';

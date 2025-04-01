<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/role/select', [RoleController::class, 'select'])->name('role.select');

Route::post('/role/assignRoleSelect', [RoleController::class, 'assignRoleSelect'])->name('role.assignRoleSelect');

Route::get('/income/delete/{income}', [IncomeController::class, 'delete'])->name('income.delete');


Route::middleware([
    'auth',
    'verified',
//    'chooseRole',
//    'middle',
    'income',
    'category'
])->group(function () {

    Route::get('category_user/monthlyCategory/{month?}', [UserCategoryController::class, 'monthlyCategory'])->name('category_user.monthlyCategory');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/category_user', UserCategoryController::class);

    Route::get('category_user/delete/{category}', [UserCategoryController::class, 'delete'])->name('category_user.delete');

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::resource('expense', ExpenseController::class);

    Route::get('/expense/delete/{expense}', [ExpenseController::class, 'delete'])->name('expense.delete');

    Route::get('/forecast/forecast/{date?}', [ForecastController::class, 'forecast'])->name('forecast.forecast');

    Route::get('/estimate/editIncome/{date}', [EstimateController::class, 'editIncome'])->name('estimate.editIncome');

    Route::put('/estimate/updateIncome/{estimate}', [EstimateController::class, 'updateIncome'])->name('estimate.updateIncome');

    Route::resource('income', IncomeController::class);
});

Route::middleware([
    'auth',
    'verified',
    'middle'
])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('/category', CategoryController::class);

    Route::resource('/role', RoleController::class);

    Route::get('/role/assignRole/{role}', [RoleController::class, 'assignRole'])->name('role.assignRole');

    Route::get('/role/removeRole/{role}/{user}', [RoleController::class, 'removeRole'])->name('role.removeRole');

    Route::get('/role/addRole/{role}/{user}', [RoleController::class, 'addRole'])->name('role.addRole');

    Route::get('/category/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('admin/user', [AdminController::class, 'users'])->name('admin.user');

    Route::get('admin/category/{user}', [AdminController::class, 'category'])->name('admin.category');

    Route::get('admin/permission/{roleId?}', [AdminController::class, 'permissions'])->name('admin.permission');

    Route::put('admin/addPermission', [AdminController::class, 'addPermission'])->name('admin.addPermission');
});

Route::middleware([
    'auth',
    'verified',
    'chooseRole',
    'middle'
])->group(function () {
    Route::get('/estimate/income', [EstimateController::class, 'income'])->name('estimate.income');

    Route::post('/estimate/addIncome', [EstimateController::class, 'storeIncome'])->name('estimate.addIncome');
});

Route::middleware([
    'auth',
    'verified',
    'chooseRole',
    'middle',
    'income'
])->group(function () {

    Route::get('/estimate/selectCategory', [EstimateController::class, 'selectCategory'])->name('estimate.selectCategory');

    Route::post('/estimate/addCategory', [EstimateController::class, 'showLimit'])->name('estimate.addCategory');

    Route::post('/estimate/addLimit', [EstimateController::class, 'storeLimit'])->name('estimate.addLimit');
});

Route::middleware([
    'auth',
    'verified',
])->group(function () {

    Route::get('/role/select', [RoleController::class, 'select'])->name('role.select');
});



require __DIR__ . '/auth.php';

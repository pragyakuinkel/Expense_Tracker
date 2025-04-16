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


Route::middleware([
    'auth',
])->group(function () {
    Route::get('/user_role/select', [ProfileController::class, 'select'])->name('user_role.select');

    Route::post('/user_role/assignRoleSelect', [ProfileController::class, 'assignRoleSelect'])->name('user_role.assignRoleSelect');
});

Route::middleware([
    'auth',
    'chooseRole',
    'income',
    'category'
])->group(function () {

    Route::get('category_user/monthlyCategory', [UserCategoryController::class, 'monthlyCategory'])->name('category_user.monthlyCategory');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/category_user', UserCategoryController::class);

    Route::get('category_user/delete/{category}/{date?}', [UserCategoryController::class, 'delete'])->name('category_user.delete');

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::resource('expense', ExpenseController::class);

    Route::get('/expense/delete/{expense}', [ExpenseController::class, 'delete'])->name('expense.delete');

    Route::get('/forecast/forecast', [ForecastController::class, 'forecast'])->name('forecast.forecast');

    Route::resource('income', IncomeController::class);

    Route::get('/income/delete/{income}', [IncomeController::class, 'delete'])->name('income.delete');

});

Route::middleware([
    'auth',
    'middle'
])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('/category', CategoryController::class)->except(['show']);

    Route::resource('/role', RoleController::class)->only(['index', 'create','store']);

    Route::get('/role/assignRole/{role}', [RoleController::class, 'assignRole'])->name('role.assignRole');

    Route::get('/role/removeRole/{role}/{user}', [RoleController::class, 'removeRole'])->name('role.removeRole');

    Route::get('/role/addRole/{role}/{user}', [RoleController::class, 'addRole'])->name('role.addRole');

    Route::get('/category/delete/{category}', [CategoryController::class, 'delete'])->name('category.deleteConfirmation');

    Route::get('/category/confirmation/{category}', [CategoryController::class, 'confirmation'])->name('category.editCategoryConfirmation');

    Route::get('/category/confirm/{category}', [CategoryController::class, 'confirm'])->name('category.editCategoryConfirm');

    Route::get('admin/user', [AdminController::class, 'users'])->name('admin.manageUser');

    Route::get('admin/category/{user}', [AdminController::class, 'category'])->name('admin.manageUserCategory');

    Route::get('admin/permission/{roleId?}', [AdminController::class, 'permissions'])->name('admin.managePermission');

    Route::put('admin/addPermission', [AdminController::class, 'addPermission'])->name('admin.addPermission');
});

Route::middleware([
    'auth',
    'chooseRole'
])->group(function () {
    Route::get('/estimate/income', [EstimateController::class, 'income'])->name('estimate.income');

    Route::post('/estimate/addIncome', [EstimateController::class, 'storeIncome'])->name('estimate.addIncome');
});

Route::middleware([
    'auth',
    'chooseRole',
    'income'
])->group(function () {

    Route::get('/estimate/selectCategory', [EstimateController::class, 'selectCategory'])->name('estimate.selectCategory');

    Route::get('/estimate/addCategory', [EstimateController::class, 'showLimit'])->name('estimate.addCategory');

    Route::post('/estimate/addLimit', [EstimateController::class, 'storeLimit'])->name('estimate.addLimit');
});



require __DIR__ . '/auth.php';

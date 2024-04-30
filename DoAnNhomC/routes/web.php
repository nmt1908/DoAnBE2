<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\BrandController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
Route::get('login', [CustomAuthController::class, 'index'])->name('login')->middleware('checkLogin');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::get('account', [PageController::class, 'accountProfile'])->name('accountProfile');

Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::get('admin/dashboard', [CustomAuthController::class, 'adminDashboard'])->name('admin.dashboard');

    // User routes
    Route::get('admin/user',[PageController::class,'adminListUser'])->name('admin.listuser');
    Route::get('admin/searchuser',[SearchUserController::class,'searchUser'])->name('admin.searchuser');
    Route::get('admin/adduser',[CrudUserController::class,'addUser'])->name('admin.adduser');
    Route::post('custom-adduser', [CrudUserController::class, 'customAddUser'])->name('admin.customAddUser');
    Route::delete('/delete-user/{id}', [CrudUserController::class, 'deleteUser'])->name('admin.deleteuser');
    Route::get('update', [CrudUserController::class, 'updateUser'])->name('admin.updateUser');
    Route::post('update', [CrudUserController::class, 'postUpdateUser'])->name('admin.postUpdateUser');

    // Category routes
    Route::get('admin/categories',[CategoryController::class,'adminListCategory'])->name('admin.listcategories');
    Route::get('admin/addcategories',[CategoryController::class,'addCategories'])->name('admin.addcategories');
    Route::post('custom-addcategories', [CategoryController::class, 'customAddCategories'])->name('admin.customAddCategories');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategories'])->name('admin.deletecategories');
    Route::get('update-categories', [CategoryController::class, 'updateCategories'])->name('admin.updateCategories');
    Route::post('update-categories', [CategoryController::class, 'postUpdateCategories'])->name('admin.postUpdateCategories');
    Route::get('admin/searchcategories',[CategoryController::class,'searchCategories'])->name('admin.searchCategories');

    // Brand routes
    Route::get('admin/brand',[BrandController::class,'adminListBrand'])->name('admin.listBrand');
    Route::get('admin/addbrand',[BrandController::class,'addBrand'])->name('admin.addBrand');
    Route::post('custom-addbrand', [BrandController::class, 'customAddBrand'])->name('admin.customAddBrand');
    Route::delete('/delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('admin.deleteBrand');
    Route::get('update-brand', [BrandController::class, 'updateBrand'])->name('admin.updateBrand');
    Route::post('update-brand', [BrandController::class, 'postUpdateBrand'])->name('admin.postUpdateBrand');
    Route::get('admin/searchbrand',[BrandController::class,'searchBrand'])->name('admin.searchBrand');

});
// Route::get('/', function () {
//     return view('user/dashboard');
// });
Route::get('/', [CustomAuthController::class, 'dashboardFirstLogin'])->name('dashboardFirstLogin');

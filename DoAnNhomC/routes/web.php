<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\CrudUserController;
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
Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::get('admin/dashboard', [CustomAuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('admin/user',[PageController::class,'adminListUser'])->name('admin.listuser');
    Route::get('admin/searchuser',[SearchUserController::class,'searchUser'])->name('admin.searchuser');
    Route::get('admin/adduser',[CrudUserController::class,'addUser'])->name('admin.adduser');
    Route::post('custom-adduser', [CrudUserController::class, 'customAddUser'])->name('admin.customAddUser');
});
Route::get('/', function () {
    return view('welcome');
});

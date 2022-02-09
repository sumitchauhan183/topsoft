<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return redirect(route('admin.login'));
});

Route::get('/admin',function(){
    return redirect(route('admin.login'));
});

// ADMIN ROUTES
Route::get('admin/login',[App\Http\Controllers\Admin\AuthController::class,'login'])->name('admin.login');
Route::get('admin/logout',[App\Http\Controllers\Admin\AuthController::class,'logout'])->name('admin.logout');

// ADMIN LOGGED IN ROUTES
Route::any('admin/dashboard',[App\Http\Controllers\Admin\DashboardController::class,'dashboard'])->name('admin.dashboard');


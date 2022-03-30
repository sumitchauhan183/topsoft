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

// CLIENTS ROUTES
Route::get('admin/clients',[App\Http\Controllers\Admin\ClientController::class,'list'])->name('admin.clients.list');
Route::get('admin/clients/add',[App\Http\Controllers\Admin\ClientController::class,'add'])->name('admin.clients.add');
Route::get('admin/clients/edit/{id}',[App\Http\Controllers\Admin\ClientController::class,'edit']);
Route::get('admin/clients/view/{id}',[App\Http\Controllers\Admin\ClientController::class,'view']);
Route::get('admin/clients/delete/{id}',[App\Http\Controllers\Admin\ClientController::class,'delete']);

// COMPANY ROUTES
Route::get('admin/company',[App\Http\Controllers\Admin\CompanyController::class,'list'])->name('admin.company.list');
Route::get('admin/company/add',[App\Http\Controllers\Admin\CompanyController::class,'add'])->name('admin.company.add');
Route::get('admin/company/edit/{id}',[App\Http\Controllers\Admin\CompanyController::class,'edit']);
Route::get('admin/company/view/{id}',[App\Http\Controllers\Admin\CompanyController::class,'view']);
Route::get('admin/company/delete/{id}',[App\Http\Controllers\Admin\CompanyController::class,'delete']);

// COMPANY LICENSE ROUTE
Route::get('admin/company/{id}/license/add',[App\Http\Controllers\Admin\LicenseController::class,'add']);
Route::get('admin/company/license/view/{license_id}',[App\Http\Controllers\Admin\LicenseController::class,'view']);
Route::get('admin/company/license/edit/{license_id}',[App\Http\Controllers\Admin\LicenseController::class,'edit']);
Route::get('admin/company/license/delete/{license_id}',[App\Http\Controllers\Admin\LicenseController::class,'delete']);

// COMPANY APP USERS
Route::get('admin/company/{id}/app-users',[App\Http\Controllers\Admin\AppUserController::class,'list']);
Route::get('admin/company/{id}/app-users/add',[App\Http\Controllers\Admin\AppUserController::class,'add']);
Route::get('admin/company/app-users/view/{app_user_id}',[App\Http\Controllers\Admin\AppUserController::class,'view']);
Route::get('admin/company/app-users/edit/{app_user_id}',[App\Http\Controllers\Admin\AppUserController::class,'edit']);
Route::get('admin/company/app-users/delete/{app_user_id}',[App\Http\Controllers\Admin\AppUserController::class,'delete']);





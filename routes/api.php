<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// ADMIN ROUTES
// ADMIN API ROUTES
Route::POST('admin/login',[App\Http\Controllers\Api\admin\LoginController::class,'login']);
Route::POST('admin/mail/check',[App\Http\Controllers\Api\admin\LoginController::class,'checkEmail']);


Route::POST('admin/clients/check/email',[App\Http\Controllers\Api\admin\ClientController::class,'checkEmailExist']);
Route::POST('admin/clients/add',[App\Http\Controllers\Api\admin\ClientController::class,'add']);
Route::POST('admin/clients/update',[App\Http\Controllers\Api\admin\ClientController::class,'update']);
Route::GET('admin/clients',[App\Http\Controllers\Api\admin\ClientController::class,'list']);

Route::POST('admin/company/check/email',[App\Http\Controllers\Api\admin\CompanyController::class,'checkEmailExist']);
Route::POST('admin/company/add',[App\Http\Controllers\Api\admin\CompanyController::class,'add']);
Route::POST('admin/company/update',[App\Http\Controllers\Api\admin\CompanyController::class,'update']);
Route::GET('admin/company',[App\Http\Controllers\Api\admin\CompanyController::class,'list']);



// Android API
Route::POST('login',[App\Http\Controllers\Api\LoginController::class,'login']);
Route::POST('forgotPassword/sendOtp',[App\Http\Controllers\Api\LoginController::class,'forgotPasswordSendOtp']);
Route::POST('forgotPassword/reset',[App\Http\Controllers\Api\LoginController::class,'forgotPasswordReset']);

Route::POST('customer/add',[App\Http\Controllers\Api\CustomerController::class,'add']);
Route::POST('customer/update',[App\Http\Controllers\Api\CustomerController::class,'update']);
Route::POST('customer/list',[App\Http\Controllers\Api\CustomerController::class,'list']);
Route::POST('customer/detail',[App\Http\Controllers\Api\CustomerController::class,'detail']);

Route::POST('item/list',[App\Http\Controllers\Api\ItemController::class,'list']);
Route::POST('item/details',[App\Http\Controllers\Api\ItemController::class,'detail']);

Route::POST('invoice/add',[App\Http\Controllers\Api\InvoiceController::class,'add']);
Route::POST('customer/update',[App\Http\Controllers\Api\InvoiceController::class,'update']);
Route::POST('invoice/list',[App\Http\Controllers\Api\InvoiceController::class,'list']);
Route::POST('invoice/details',[App\Http\Controllers\Api\InvoiceController::class,'detail']);


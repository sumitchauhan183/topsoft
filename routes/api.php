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
Route::POST('admin/clients',[App\Http\Controllers\Api\admin\ClientController::class,'list']);

Route::POST('admin/items/add',[App\Http\Controllers\Api\admin\ItemsController::class,'add']);
Route::POST('admin/items/update',[App\Http\Controllers\Api\admin\ItemsController::class,'update']);
Route::POST('admin/items',[App\Http\Controllers\Api\admin\ItemsController::class,'list']);

Route::POST('admin/invoices',[App\Http\Controllers\Api\admin\InvoiceController::class,'list']);
Route::POST('admin/receipts',[App\Http\Controllers\Api\admin\ReceiptController::class,'list']);

Route::POST('admin/company/check/email',[App\Http\Controllers\Api\admin\CompanyController::class,'checkEmailExist']);
Route::POST('admin/company/add',[App\Http\Controllers\Api\admin\CompanyController::class,'add']);
Route::POST('admin/company/update',[App\Http\Controllers\Api\admin\CompanyController::class,'update']);
Route::GET('admin/company',[App\Http\Controllers\Api\admin\CompanyController::class,'list']);

Route::POST('admin/app-users/check/email',[App\Http\Controllers\Api\admin\AppUserController::class,'checkEmailExist']);
Route::POST('admin/app-users/add',[App\Http\Controllers\Api\admin\AppUserController::class,'add']);
Route::POST('admin/app-users/update',[App\Http\Controllers\Api\admin\AppUserController::class,'update']);
Route::POST('admin/app-users',[App\Http\Controllers\Api\admin\AppUserController::class,'list']);

Route::POST('admin/company/license/add',[App\Http\Controllers\Api\admin\LicenseController::class,'add']);
Route::POST('admin/company/license/update',[App\Http\Controllers\Api\admin\LicenseController::class,'update']);

// Android API
Route::POST('login',[App\Http\Controllers\Api\LoginController::class,'login']);
Route::POST('forgotPassword/sendOtp',[App\Http\Controllers\Api\LoginController::class,'forgotPasswordSendOtp']);
Route::POST('forgotPassword/reset',[App\Http\Controllers\Api\LoginController::class,'forgotPasswordReset']);

Route::POST('customer/add',[App\Http\Controllers\Api\CustomerController::class,'add']);
Route::POST('customer/update',[App\Http\Controllers\Api\CustomerController::class,'update']);
Route::POST('customer/list',[App\Http\Controllers\Api\CustomerController::class,'list']);
Route::POST('customer/detail',[App\Http\Controllers\Api\CustomerController::class,'detail']);
Route::POST('customer/search',[App\Http\Controllers\Api\CustomerController::class,'search']);
Route::POST('customer/invoices',[App\Http\Controllers\Api\CustomerController::class,'invoices']);


Route::POST('event/add',[App\Http\Controllers\Api\EventController::class,'add']);
Route::POST('event/update',[App\Http\Controllers\Api\EventController::class,'update']);
Route::POST('event/list',[App\Http\Controllers\Api\EventController::class,'list']);
Route::POST('event/list/type',[App\Http\Controllers\Api\EventController::class,'listbytype']);
Route::POST('event/list/status',[App\Http\Controllers\Api\EventController::class,'listbystatus']);
Route::POST('event/list/client',[App\Http\Controllers\Api\EventController::class,'listbyclient']);
Route::POST('event/delete',[App\Http\Controllers\Api\EventController::class,'delete']);

Route::POST('item/add',[App\Http\Controllers\Api\ItemController::class,'add']);
Route::POST('item/update',[App\Http\Controllers\Api\ItemController::class,'update']);
Route::POST('item/list',[App\Http\Controllers\Api\ItemController::class,'list']);
Route::POST('item/details',[App\Http\Controllers\Api\ItemController::class,'detail']);
Route::POST('item/search',[App\Http\Controllers\Api\ItemController::class,'search']);
Route::POST('item/details/barcode',[App\Http\Controllers\Api\ItemController::class,'detailByBarcode']);

Route::POST('invoice/add',[App\Http\Controllers\Api\InvoiceController::class,'add']);
Route::POST('invoice/update',[App\Http\Controllers\Api\InvoiceController::class,'update']);
Route::POST('invoice/list',[App\Http\Controllers\Api\InvoiceController::class,'list']);
Route::POST('invoice/details',[App\Http\Controllers\Api\InvoiceController::class,'detail']);
Route::POST('invoice/items',[App\Http\Controllers\Api\InvoiceController::class,'items']);
Route::POST('invoice/item/quantity/update',[App\Http\Controllers\Api\InvoiceController::class,'itemQuantityUpdate']);

Route::POST('receipt/add',[App\Http\Controllers\Api\ReceiptController::class,'add']);
Route::POST('receipt/update',[App\Http\Controllers\Api\ReceiptController::class,'update']);
Route::POST('receipt/list',[App\Http\Controllers\Api\ReceiptController::class,'list']);
Route::POST('receipt/details',[App\Http\Controllers\Api\ReceiptController::class,'detail']);


// ERP API
Route::POST('erp/customer/add',[App\Http\Controllers\Api\ERP\CustomerController::class,'add']);
Route::POST('erp/customer/update',[App\Http\Controllers\Api\ERP\CustomerController::class,'update']);
Route::POST('erp/customer/list',[App\Http\Controllers\Api\ERP\CustomerController::class,'list']);
Route::POST('erp/customer/detail',[App\Http\Controllers\Api\ERP\CustomerController::class,'detail']);
Route::POST('erp/customer/search',[App\Http\Controllers\Api\ERP\CustomerController::class,'search']);
Route::POST('erp/customer/invoices',[App\Http\Controllers\Api\ERP\CustomerController::class,'invoices']);


Route::POST('erp/event/list',[App\Http\Controllers\Api\ERP\EventController::class,'list']);
Route::POST('erp/event/list/type',[App\Http\Controllers\Api\ERP\EventController::class,'listbytype']);
Route::POST('erp/event/list/status',[App\Http\Controllers\Api\ERP\EventController::class,'listbystatus']);
Route::POST('erp/event/list/client',[App\Http\Controllers\Api\ERP\EventController::class,'listbyclient']);

Route::POST('erp/item/add',[App\Http\Controllers\Api\ERP\ItemController::class,'add']);
Route::POST('erp/item/update',[App\Http\Controllers\Api\ERP\ItemController::class,'update']);
Route::POST('erp/item/list',[App\Http\Controllers\Api\ERP\ItemController::class,'list']);
Route::POST('erp/item/details',[App\Http\Controllers\Api\ERP\ItemController::class,'detail']);
Route::POST('erp/item/search',[App\Http\Controllers\Api\ERP\ItemController::class,'search']);
Route::POST('erp/item/details/barcode',[App\Http\Controllers\Api\ERP\ItemController::class,'detailByBarcode']);

Route::POST('erp/invoice/list',[App\Http\Controllers\Api\ERP\InvoiceController::class,'list']);
Route::POST('erp/invoice/details',[App\Http\Controllers\Api\ERP\InvoiceController::class,'detail']);
Route::POST('erp/invoice/items',[App\Http\Controllers\Api\ERP\InvoiceController::class,'items']);


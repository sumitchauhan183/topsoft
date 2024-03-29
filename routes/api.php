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
Route::POST('admin/profile/update',[App\Http\Controllers\Api\admin\LoginController::class,'update']);

Route::POST('admin/clients/check/email',[App\Http\Controllers\Api\admin\ClientController::class,'checkEmailExist']);
Route::POST('admin/clients/add',[App\Http\Controllers\Api\admin\ClientController::class,'add']);
Route::POST('admin/clients/update',[App\Http\Controllers\Api\admin\ClientController::class,'update']);
Route::POST('admin/clients',[App\Http\Controllers\Api\admin\ClientController::class,'list']);

Route::POST('admin/items/add',[App\Http\Controllers\Api\admin\ItemsController::class,'add']);
Route::POST('admin/items/update',[App\Http\Controllers\Api\admin\ItemsController::class,'update']);
Route::POST('admin/items',[App\Http\Controllers\Api\admin\ItemsController::class,'list']);

Route::POST('admin/invoices',[App\Http\Controllers\Api\admin\InvoiceController::class,'list']);
Route::POST('admin/events',[App\Http\Controllers\Api\admin\EventController::class,'list']);
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
Route::POST('checklist/list',[App\Http\Controllers\Api\ChecklistController::class,'list']);
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
Route::POST('invoice/delete',[App\Http\Controllers\Api\InvoiceController::class,'delete']);
Route::POST('invoice/multi/delete',[App\Http\Controllers\Api\InvoiceController::class,'multidelete']);
Route::POST('invoice/pdf',[App\Http\Controllers\Api\InvoiceController::class,'invoicePDF']);


Route::POST('receipt/add',[App\Http\Controllers\Api\ReceiptController::class,'add']);
Route::POST('receipt/update',[App\Http\Controllers\Api\ReceiptController::class,'update']);
Route::POST('receipt/list',[App\Http\Controllers\Api\ReceiptController::class,'list']);
Route::POST('receipt/details',[App\Http\Controllers\Api\ReceiptController::class,'detail']);
Route::POST('receipt/pdf',[App\Http\Controllers\Api\ReceiptController::class,'receiptPDF']);
Route::POST('receipt/delete',[App\Http\Controllers\Api\ReceiptController::class,'delete']);
Route::POST('receipt/multi/delete',[App\Http\Controllers\Api\ReceiptController::class,'multidelete']);

Route::POST('chat/send',[App\Http\Controllers\Api\ChatController::class,'send']);
Route::POST('chat/messages',[App\Http\Controllers\Api\ChatController::class,'messages']);
Route::POST('chat/delete',[App\Http\Controllers\Api\ChatController::class,'delete']);
Route::POST('chat/delete/all',[App\Http\Controllers\Api\ChatController::class,'deleteAll']);

Route::POST('warehouse/items',[App\Http\Controllers\Api\WarehouseController::class,'items']);
Route::POST('warehouse/items/add',[App\Http\Controllers\Api\WarehouseController::class,'addItems']);
Route::POST('warehouse/items/remove',[App\Http\Controllers\Api\WarehouseController::class,'removeItems']);


Route::POST('general/invoiceTypes',[App\Http\Controllers\Api\GeneralController::class,'invoiceTypes']);
Route::POST('general/checklist',[App\Http\Controllers\Api\GeneralController::class,'checklists']);

// ERP API
// ERP API
Route::POST('erp/company/add',[App\Http\Controllers\Api\ERP\CompanyController::class,'add']);
Route::POST('erp/company/update',[App\Http\Controllers\Api\ERP\CompanyController::class,'update']);
Route::POST('erp/company/list',[App\Http\Controllers\Api\ERP\CompanyController::class,'list']);
Route::POST('erp/company/detail',[App\Http\Controllers\Api\ERP\CompanyController::class,'detail']);
Route::POST('erp/company/delete',[App\Http\Controllers\Api\ERP\CompanyController::class,'delete']);

Route::POST('erp/customer/add',[App\Http\Controllers\Api\ERP\CustomerController::class,'add']);
Route::POST('erp/customer/update',[App\Http\Controllers\Api\ERP\CustomerController::class,'update']);
Route::POST('erp/customer/list',[App\Http\Controllers\Api\ERP\CustomerController::class,'list']);
Route::POST('erp/customer/detail',[App\Http\Controllers\Api\ERP\CustomerController::class,'detail']);
Route::POST('erp/customer/delete',[App\Http\Controllers\Api\ERP\CustomerController::class,'delete']);
Route::POST('erp/customer/invoices',[App\Http\Controllers\Api\ERP\CustomerController::class,'invoices']);
Route::POST('erp/customer/search',[App\Http\Controllers\Api\ERP\CustomerController::class,'search']);

Route::POST('erp/devices/add',[App\Http\Controllers\Api\ERP\AppUserController::class,'add']);
Route::POST('erp/devices/update',[App\Http\Controllers\Api\ERP\AppUserController::class,'update']);
Route::POST('erp/devices/detail',[App\Http\Controllers\Api\ERP\AppUserController::class,'detail']);
Route::POST('erp/devices/delete',[App\Http\Controllers\Api\ERP\AppUserController::class,'delete']);
Route::POST('erp/devices',[App\Http\Controllers\Api\ERP\AppUserController::class,'list']);
Route::POST('erp/devices/company',[App\Http\Controllers\Api\ERP\AppUserController::class,'listByCompany']);

Route::POST('erp/item/add',[App\Http\Controllers\Api\ERP\ItemController::class,'add']);
Route::POST('erp/item/update',[App\Http\Controllers\Api\ERP\ItemController::class,'update']);
Route::POST('erp/item/list',[App\Http\Controllers\Api\ERP\ItemController::class,'list']);
Route::POST('erp/item/details',[App\Http\Controllers\Api\ERP\ItemController::class,'detail']);
Route::POST('erp/item/delete',[App\Http\Controllers\Api\ERP\ItemController::class,'delete']);
Route::POST('erp/item/search',[App\Http\Controllers\Api\ERP\ItemController::class,'search']);
Route::POST('erp/item/details/barcode',[App\Http\Controllers\Api\ERP\ItemController::class,'detailByBarcode']);

Route::POST('erp/receipt/add',[App\Http\Controllers\Api\ERP\ReceiptController::class,'add']);
Route::POST('erp/receipt/update',[App\Http\Controllers\Api\ERP\ReceiptController::class,'update']);
Route::POST('erp/receipt/list',[App\Http\Controllers\Api\ERP\ReceiptController::class,'list']);
Route::POST('erp/receipt/list/client',[App\Http\Controllers\Api\ERP\ReceiptController::class,'listbyclient']);
Route::POST('erp/receipt/details',[App\Http\Controllers\Api\ERP\ReceiptController::class,'detail']);
Route::POST('erp/receipt/delete',[App\Http\Controllers\Api\ERP\ReceiptController::class,'delete']);

Route::POST('erp/chat/list',[App\Http\Controllers\Api\ERP\ChatController::class,'messagesList']);
Route::POST('erp/chat/messages',[App\Http\Controllers\Api\ERP\ChatController::class,'messages']);
Route::POST('erp/chat/send',[App\Http\Controllers\Api\ERP\ChatController::class,'send']);
Route::POST('erp/chat/delete',[App\Http\Controllers\Api\ERP\ChatController::class,'delete']);
Route::POST('erp/chat/delete/all',[App\Http\Controllers\Api\ERP\ChatController::class,'deleteAll']);

Route::POST('erp/event/add',[App\Http\Controllers\Api\ERP\EventController::class,'add']);
Route::POST('erp/event/update',[App\Http\Controllers\Api\ERP\EventController::class,'update']);
Route::POST('erp/event/delete',[App\Http\Controllers\Api\ERP\EventController::class,'delete']);
Route::POST('erp/event/list/device',[App\Http\Controllers\Api\ERP\EventController::class,'listbydevice']);
Route::POST('erp/event/list/client',[App\Http\Controllers\Api\ERP\EventController::class,'listbyclient']);
Route::POST('erp/event/list/company',[App\Http\Controllers\Api\ERP\EventController::class,'listbycompany']);


Route::POST('erp/invoice/list',[App\Http\Controllers\Api\ERP\InvoiceController::class,'listbycompany']);
Route::POST('erp/invoice/list/client',[App\Http\Controllers\Api\ERP\InvoiceController::class,'listbyclient']);
Route::POST('erp/invoice/list/type',[App\Http\Controllers\Api\ERP\InvoiceController::class,'listbytype']);
Route::POST('erp/invoice/list/client/type',[App\Http\Controllers\Api\ERP\InvoiceController::class,'listbyclientwithtype']);
Route::POST('erp/invoice/list/status',[App\Http\Controllers\Api\ERP\InvoiceController::class,'listbystatus']);
Route::POST('erp/invoice/list/client/status',[App\Http\Controllers\Api\ERP\InvoiceController::class,'listbyclientwithstatus']);
Route::POST('erp/invoice/details',[App\Http\Controllers\Api\ERP\InvoiceController::class,'details']);


Route::POST('erp/invoice_type/add',[App\Http\Controllers\Api\ERP\InvoiceTypeController::class,'add']);
Route::POST('erp/invoice_type/update',[App\Http\Controllers\Api\ERP\InvoiceTypeController::class,'update']);
Route::POST('erp/invoice_type/list',[App\Http\Controllers\Api\ERP\InvoiceTypeController::class,'list']);
Route::POST('erp/invoice_type/delete',[App\Http\Controllers\Api\ERP\InvoiceTypeController::class,'delete']);

Route::POST('erp/license/add',[App\Http\Controllers\Api\ERP\LicenseController::class,'add']);
Route::POST('erp/license/update',[App\Http\Controllers\Api\ERP\LicenseController::class,'update']);
Route::POST('erp/license/detail',[App\Http\Controllers\Api\ERP\LicenseController::class,'detail']);
Route::POST('erp/license/delete',[App\Http\Controllers\Api\ERP\LicenseController::class,'delete']);

Route::POST('erp/checklist/add',[App\Http\Controllers\Api\ERP\ChecklistController::class,'add']);
Route::POST('erp/checklist/update',[App\Http\Controllers\Api\ERP\ChecklistController::class,'update']);
Route::POST('erp/checklist/list',[App\Http\Controllers\Api\ERP\ChecklistController::class,'list']);
Route::POST('erp/checklist/detail',[App\Http\Controllers\Api\ERP\ChecklistController::class,'detail']);
Route::POST('erp/checklist/delete',[App\Http\Controllers\Api\ERP\ChecklistController::class,'delete']);
Route::POST('erp/checklist/delete/all',[App\Http\Controllers\Api\ERP\ChecklistController::class,'deleteall']);

Route::POST('erp/sync/customers',[App\Http\Controllers\Api\ERP\SyncController::class,'customers']);
Route::POST('erp/sync/invoices',[App\Http\Controllers\Api\ERP\SyncController::class,'invoices']);
Route::POST('erp/sync/receipts',[App\Http\Controllers\Api\ERP\SyncController::class,'receipts']);
Route::POST('erp/sync/events',[App\Http\Controllers\Api\ERP\SyncController::class,'events']);
Route::POST('erp/sync/items',[App\Http\Controllers\Api\ERP\SyncController::class,'items']);


Route::POST('erp/app/modules',[App\Http\Controllers\Api\ERP\ModuleController::class,'list']);












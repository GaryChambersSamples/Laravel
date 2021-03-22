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

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TenantController;


// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class, 'index'])->middleware('auth');

//Apartment Routes
Route::get('/apartments/create/{property}', [ApartmentController::class, 'create']); //id is passed for the property the apt belongs to
Route::post('/apartments', [ApartmentController::class, 'store']);
Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->middleware('auth');
Route::get('/apartments/{apartment}/edit', [ApartmentController::class, 'edit'])->middleware('auth');
Route::patch('/apartments/{apartment}', [ApartmentController::class, 'update'])->middleware('auth');
Route::delete('/apartments/{apartment}', [ApartmentController::class, 'destroy'])->middleware('auth');

//Billing Routes
// Route::get('/billings/{billing}', [BillingController::class, 'show'])->middleware('auth');
Route::post('/billings/{tenant}', [BillingController::class, 'store']);
Route::get('/billings/{tenant}/index', [BillingController::class, 'index'])->middleware('auth');


//Contractor Routes
Route::get('/contractors', [ContractorController::class, 'index'])->middleware('auth');
Route::get('/contractors/create', [ContractorController::class, 'create']);
Route::post('/contractors', [ContractorController::class, 'store']);
Route::get('/contractors/{contractor}', [ContractorController::class, 'show'])->middleware('auth');
Route::get('/contractors/{contractor}/edit', [ContractorController::class, 'edit'])->middleware('auth');
Route::patch('/contractors/{contractor}', [ContractorController::class, 'update'])->middleware('auth');
Route::delete('/contractors/{contractor}', [ContractorController::class, 'destroy'])->middleware('auth');

//email
Route::get('/contact', [ContactFormController::class, 'create']);
Route::post('/contact', [ContactFormController::class, 'store']);

//expense Routes
Route::get('/properties/expenses/{property}', [ExpenseController::class, 'index'])->middleware('auth');
Route::get('/properties/expenses/{property}/create', [ExpenseController::class, 'create']);
Route::post('/properties/expenses/{property}', [ExpenseController::class, 'store']);
Route::get('/properties/expenses/{expense}', [ExpenseController::class, 'show'])->middleware('auth');
Route::get('/properties/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->middleware('auth');
Route::patch('/properties/expenses/{expense}', [ExpenseController::class, 'update'])->middleware('auth');
Route::delete('/properties/expenses/{expense}', [ExpenseController::class, 'destroy'])->middleware('auth');


//Owner Routes
Route::get('/owners', [OwnerController::class, 'index'])->middleware('auth');
Route::get('/owners/create', [OwnerController::class, 'create']);
Route::post('/owners', [OwnerController::class, 'store']);
Route::get('/owners/{owner}', [OwnerController::class, 'show'])->middleware('auth');
Route::get('/owners/{owner}/edit', [OwnerController::class, 'edit'])->middleware('auth');
Route::patch('/owners/{owner}', [OwnerController::class, 'update'])->middleware('auth');
Route::delete('/owners/{owner}', [OwnerController::class, 'destroy'])->middleware('auth');

//Possible route for owner/address create
// Route::get('/owners/{owner}/adresses/create', [OwnerController::class, 'create']);

//All of the routes above can be replaced with Route::resource('owners', OwnerController);


//Property Routes
Route::get('/properties', [PropertyController::class, 'index'])->middleware('auth');
Route::get('/properties/create', [PropertyController::class, 'create']);
Route::post('/properties', [PropertyController::class, 'store']);
Route::get('/properties/{property}', [PropertyController::class, 'show'])->middleware('auth');
Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->middleware('auth');
Route::patch('/properties/{property}', [PropertyController::class, 'update'])->middleware('auth');
Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->middleware('auth');

//Supplier Routes
Route::get('/suppliers', [SupplierController::class, 'index'])->middleware('auth');
Route::get('/suppliers/create', [SupplierController::class, 'create']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->middleware('auth');
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->middleware('auth');
Route::patch('/suppliers/{supplier}', [SupplierController::class, 'update'])->middleware('auth');
Route::delete('/supliers/{supplier}', [SupplierController::class, 'destroy'])->middleware('auth');

//Tenant Routes
Route::get('/tenants', [TenantController::class, 'index'])->middleware('auth');
Route::get('/tenants/indexInactive', [TenantController::class, 'indexInactive'])->middleware('auth');
Route::get('/tenants/create', [TenantController::class, 'create']);
Route::post('/tenants', [TenantController::class, 'store']);
Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->middleware('auth');
Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->middleware('auth');
Route::get('/tenants/{tenant}/changeActivation', [TenantController::class, 'changeActivation'])->middleware('auth');
Route::get('/tenants/{tenant}/lease', [TenantController::class, 'generateLease'])->middleware('auth');
Route::get('/tenants/{tenant}/invoice', [TenantController::class, 'generateInvoice'])->middleware('auth');
Route::patch('/tenants/{tenant}', [TenantController::class, 'update'])->middleware('auth');
// Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->middleware('auth');


//Authentication Routes
Auth::routes([
    'register' => true
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
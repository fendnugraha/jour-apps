<?php

use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\AccountTraceController;
use App\Http\Controllers\ChartOfAccountController;

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

// Login Area
Route::get('/', [AuthController::class, 'index'])->middleware('guest');

Route::post('/', [AuthController::class, 'authenticate'])->name('login')->middleware('guest');
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::get('/auth/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/auth/register', [AuthController::class, 'store']);

Route::get('/auth/register_success', function () {
    return view('auth/register_success');
})->middleware('guest');

// End Login Area
// ========================================================================================================

// Home Area
Route::get('/home', [AccountTraceController::class, 'index'])->middleware('auth');
Route::get('/setting', function () {
    return view('home.setting', [
        'title' => 'Setting',
    ]);
})->middleware('auth');

Route::get('/report', function () {
    return view('home.report', [
        'title' => 'Report',
        'account' => ChartOfAccount::all()
    ]);
})->middleware('auth');


// End Home Area
// ========================================================================================================

// Jurnal Area
Route::get('/jurnal', [AccountTraceController::class, 'index'])->middleware('auth');
Route::get('/jurnal/addjournal', [AccountTraceController::class, 'addjournal'])->middleware('auth');
Route::post('/jurnal/addjournal', [AccountTraceController::class, 'store'])->middleware('auth');
Route::get('/jurnal/adddeposit', [AccountTraceController::class, 'adddeposit'])->middleware('auth');

Route::get('/jurnal/addSalesValues', [AccountTraceController::class, 'addSalesValues'])->middleware('auth');
Route::post('/jurnal/addSalesValues', [AccountTraceController::class, 'storeSalesValues'])->middleware('auth');

Route::get('/jurnal/{id}/edit', [AccountTraceController::class, 'edit'])->middleware('auth');
Route::put('/jurnal/{id}/edit', [AccountTraceController::class, 'update'])->name('jurnal.update')->middleware('auth');
Route::delete('/jurnal/{id}/delete', [AccountTraceController::class, 'destroy'])->name('jurnal.delete')->middleware('auth');


// End Jurnal Area
// ========================================================================================================

// Piutang Area
Route::get('/piutang', [ReceivableController::class, 'index'])->middleware('auth');
Route::get('/piutang/{id}/invoice', [ReceivableController::class, 'invoice'])->middleware('auth');
Route::get('/piutang/addPiutang', [ReceivableController::class, 'addReceivable'])->middleware('auth');
Route::post('/piutang/addPiutang', [ReceivableController::class, 'store'])->middleware('auth');
Route::get('/piutang/{id}/edit', [ReceivableController::class, 'edit'])->middleware('auth');
Route::put('/piutang/{id}/edit', [ReceivableController::class, 'update'])->name('piutang.update')->middleware('auth');
Route::delete('/piutang/{id}/delete', [ReceivableController::class, 'destroy'])->name('piutang.delete')->middleware('auth');
Route::get('/piutang/{id}/detail', [ReceivableController::class, 'detail'])->middleware('auth');

Route::post('piutang/payment', [ReceivableController::class, 'storePayment'])->middleware('auth');

Route::get('/piutang/addReceivableDeposit', [ReceivableController::class, 'addReceivableDeposit'])->middleware('auth');

Route::get('/piutang/addReceivableSales', [ReceivableController::class, 'addReceivableSales'])->middleware('auth');
Route::post('/piutang/addReceivableSales', [ReceivableController::class, 'storeReceivableSales'])->middleware('auth');


// End Piutang Area
// ========================================================================================================

// Hutang Area
Route::get('/hutang', [PayableController::class, 'index'])->middleware('auth');
Route::get('/hutang/{id}/invoice', [PayableController::class, 'invoice'])->middleware('auth');
Route::get('/hutang/add', [PayableController::class, 'create'])->middleware('auth');
Route::post('/hutang/add', [PayableController::class, 'store'])->middleware('auth');
Route::get('/hutang/{id}/detail', [PayableController::class, 'detail'])->middleware('auth');
Route::get('/hutang/{id}/edit', [PayableController::class, 'edit'])->middleware('auth');
Route::put('/hutang/{id}/edit', [PayableController::class, 'update'])->name('hutang.update')->middleware('auth');
Route::delete('/hutang/{id}/delete', [PayableController::class, 'destroy'])->name('hutang.delete')->middleware('auth');

Route::post('hutang/payment', [PayableController::class, 'payment'])->middleware('auth');

// End Hutang Area
// ========================================================================================================

// ChartOfAccount Area

Route::get('/setting/accounts', [ChartOfAccountController::class, 'index'])->middleware('auth');
Route::get('/setting/accounts/add', [ChartOfAccountController::class, 'addaccount'])->middleware('auth');
Route::post('/setting/accounts/add', [ChartOfAccountController::class, 'store'])->middleware('auth');
Route::get('/setting/accounts/{id}/edit', [ChartOfAccountController::class, 'edit'])->middleware('auth');
Route::put('/setting/accounts/{id}/edit', [ChartOfAccountController::class, 'update'])->name('coa.update')->middleware('auth');
Route::delete('/setting/accounts/{id}/delete', [ChartOfAccountController::class, 'destroy'])->name('coa.delete')->middleware('auth');

// End ChartOfAccount Area
// ========================================================================================================

// Contact Area

Route::get('/setting/contacts', [ContactController::class, 'index'])->middleware('auth');
Route::post('/setting/contacts/add', [ContactController::class, 'store'])->middleware('auth');
Route::get('/setting/contacts/{id}/edit', [ContactController::class, 'edit'])->middleware('auth');
Route::put('/setting/contacts/{id}/edit', [ContactController::class, 'update'])->name('contact.update')->middleware('auth');
Route::delete('/setting/contacts/{id}/delete', [ContactController::class, 'destroy'])->name('contact.delete')->middleware('auth');

// End Contact Area
// ========================================================================================================

// User Area

Route::get('/setting/users', [AuthController::class, 'users'])->middleware('auth');
Route::post('/setting/user/add', [AuthController::class, 'store'])->middleware('auth');
Route::get('/setting/user/{id}/edit', [AuthController::class, 'edit'])->middleware('auth');
Route::put('/setting/user/{id}/edit', [AuthController::class, 'update'])->name('user.update')->middleware('auth');
Route::delete('/setting/user/{id}/delete', [AuthController::class, 'destroy'])->name('user.delete')->middleware('auth');

// End User Area
// ========================================================================================================

// Warehouse Area

Route::get('/setting/warehouses', [WarehouseController::class, 'index'])->middleware('auth');
Route::post('/setting/warehouse/add', [WarehouseController::class, 'store'])->middleware('auth');
Route::get('/setting/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->middleware('auth');
Route::put('/setting/warehouse/{id}/edit', [WarehouseController::class, 'update'])->name('warehouse.update')->middleware('auth');
Route::delete('/setting/warehouse/{id}/delete', [WarehouseController::class, 'destroy'])->name('warehouse.delete')->middleware('auth');

// End Warehouse Area
// ========================================================================================================

// Report Area

Route::get('/report/cashflow', [ReportController::class, 'index'])->middleware('auth');
Route::post('/report/general-ledger', [ReportController::class, 'generalLedger'])->middleware('auth');
Route::post('/report/balance-sheet', [ReportController::class, 'balanceSheet'])->middleware('auth');
Route::post('/report/profit-loss', [ReportController::class, 'profitLoss'])->middleware('auth');

// End Report Area
// ========================================================================================================

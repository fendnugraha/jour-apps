<?php

use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\AccountTraceController;
use App\Http\Controllers\ChartOfAccountController;
use App\Models\Receivable;

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
Route::get('/home', [ReportController::class, 'index'])->middleware('auth');
Route::get('/setting', function () {
    return view('home.setting', [
        'title' => 'Setting',
    ]);
})->middleware('auth');

Route::get('/report', function () {
    return view('home.report', [
        'title' => 'Report',
        'account' => ChartOfAccount::orderBy('acc_code', 'asc')->get(),
    ]);
})->middleware('auth');

Route::get('setting/general', [SettingController::class, 'index'])->middleware('auth');
Route::put('setting/general/{id}/update', [SettingController::class, 'update'])->name('profile.update')->middleware('auth');


// End Home Area
// ========================================================================================================

// Jurnal Area
Route::controller(AccountTraceController::class)->group(function () {
    Route::get('/jurnal', 'index')->name('jurnal.index')->middleware('auth');
    Route::get('/jurnal/addjournal', 'addjournal')->middleware('auth');
    Route::post('/jurnal/addjournal', 'store')->middleware('auth');
    Route::get('/jurnal/adddeposit', 'adddeposit')->middleware('auth');

    Route::get('/jurnal/addSalesValues', 'addSalesValues')->middleware('auth');
    Route::post('/jurnal/addSalesValues', 'storeSalesValues')->middleware('auth');

    Route::get('/jurnal/{id}/edit', 'edit')->middleware('auth');
    Route::put('/jurnal/{id}/edit', 'update')->name('jurnal.update')->middleware('auth');
    Route::delete('/jurnal/{id}/delete', 'destroy')->name('jurnal.delete')->middleware('auth');
});


// End Jurnal Area
// ========================================================================================================

// Piutang Area
Route::controller(ReceivableController::class)->group(function () {
    Route::get('/piutang', 'index')->middleware('auth');
    Route::get('/piutang/{id}/invoice', 'invoice')->middleware('auth');
    Route::get('/piutang/addPiutang', 'addReceivable')->middleware('auth');
    Route::post('/piutang/addPiutang', 'store')->middleware('auth');
    Route::get('/piutang/{id}/edit', 'edit')->middleware('auth');
    Route::put('/piutang/{id}/edit', 'update')->name('piutang.update')->middleware('auth');
    Route::delete('/piutang/{id}/delete', 'destroy')->name('piutang.delete')->middleware('auth');
    Route::get('/piutang/{id}/detail', 'detail')->middleware('auth');

    Route::post('piutang/payment', 'storePayment')->middleware('auth');

    Route::get('/piutang/addReceivableDeposit', 'addReceivableDeposit')->middleware('auth');

    Route::get('/piutang/addReceivableSales', 'addReceivableSales')->middleware('auth');
    Route::post('/piutang/addReceivableSales', 'storeReceivableSales')->middleware('auth');

    Route::get('receivable/export/', 'export')->middleware('auth');
});


// End Piutang Area
// ========================================================================================================

// Hutang Area
Route::controller(PayableController::class)->group(function () {
    Route::get('/hutang', 'index')->middleware('auth');
    Route::get('/hutang/{id}/invoice', 'invoice')->middleware('auth');
    Route::get('/hutang/add', 'create')->middleware('auth');
    Route::post('/hutang/add', 'store')->middleware('auth');
    Route::get('/hutang/{id}/detail', 'detail')->middleware('auth');
    Route::get('/hutang/{id}/edit', 'edit')->middleware('auth');
    Route::put('/hutang/{id}/edit', 'update')->name('hutang.update')->middleware('auth');
    Route::delete('/hutang/{id}/delete', 'destroy')->name('hutang.delete')->middleware('auth');

    Route::post('hutang/payment', 'payment')->middleware('auth');
});

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

Route::post('/report', [ReportController::class, 'index'])->middleware('auth');
Route::post('/report/cashflow', [ReportController::class, 'cashflow'])->middleware('auth');
Route::post('/report/general-ledger', [ReportController::class, 'generalLedger'])->middleware('auth');
Route::post('/report/balance-sheet', [ReportController::class, 'balanceSheet'])->middleware('auth');
Route::post('/report/profit-loss', [ReportController::class, 'profitLoss'])->middleware('auth');
Route::post('/report/daily-profit', [ReportController::class, 'dailyProfit'])->middleware('auth');
Route::post('/report/cash-bank', [ReportController::class, 'cashBankReport'])->middleware('auth');

// End Report Area
// ========================================================================================================

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
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


// End Home Area
// ========================================================================================================

// Jurnal Area
Route::get('/jurnal', [AccountTraceController::class, 'index'])->middleware('auth');
Route::get('/jurnal/addjournal', [AccountTraceController::class, 'addjournal'])->middleware('auth');
Route::post('/jurnal/addjournal', [AccountTraceController::class, 'store'])->middleware('auth');
Route::get('/jurnal/adddeposit', [AccountTraceController::class, 'adddeposit'])->middleware('auth');
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
Route::get('/piutang/{id}/edit-detail', [ReceivableController::class, 'editDetail'])->middleware('auth');
Route::post('/piutang/{id}/edit-detail', [ReceivableController::class, 'updateDetail'])->middleware('auth');
Route::post('piutang/payment', [ReceivableController::class, 'storePayment'])->middleware('auth');
Route::get('/piutang/addReceivableDeposit', [ReceivableController::class, 'addReceivableDeposit'])->middleware('auth');


// End Piutang Area
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

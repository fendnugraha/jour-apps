<?php

use App\Http\Controllers\AccountTraceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;
use App\Models\AccountTrace;
use Illuminate\Support\Facades\Route;


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
Route::get('/', [AuthController::class, 'index']);

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
Route::get('/home/jurnal', [AccountTraceController::class, 'jurnal'])->middleware('auth');
Route::get('/home/addjournal', [AccountTraceController::class, 'addjournal'])->middleware('auth');


// End Home Area
// ========================================================================================================
// Setting Area
Route::get('/setting', [SettingController::class, 'index'])->middleware('auth');
Route::get('/setting/accounts', [SettingController::class, 'accounts'])->middleware('auth');

<?php

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

Route::redirect('/', '/login');

Route::get('dashboard', [App\Http\Controllers\DashboardContoller::class, 'index'])->name('dashboard')->middleware('auth');

// Login
Route::get('login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('authLogin', [App\Http\Controllers\LoginController::class, 'login'])->name('authLogin');

// Logout
// Sementara get dulu karena belum ada fitur logoutnya, sebatas test logout
Route::get('logout', [App\Http\Controllers\LogoutController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('user')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('{user}/get', [\App\Http\Controllers\UserController::class, 'get'])->name('user.get');
    Route::put('{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('{user}/delete', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
});

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

Route::redirect('/', '/dashboard');

Route::get('dashboard', [App\Http\Controllers\DashboardContoller::class, 'index'])->name('dashboard');

// Login
Route::get('login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');

Route::prefix('user')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('{user}/get', [\App\Http\Controllers\UserController::class, 'get'])->name('user.get');
    Route::put('{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('{user}/delete', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
});

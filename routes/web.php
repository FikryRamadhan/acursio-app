<?php

use FontLib\Table\Type\name;
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

/**
 * Route Midleware Guest
 */
Route::middleware('guest')->group(function(){
    // Login
    Route::get('login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('authLogin', [App\Http\Controllers\LoginController::class, 'login'])->name('authLogin');
});


/**
 * Route Middleware Authentication
 */
Route::middleware('auth')->group(function(){
    // Dahboard Route
    Route::redirect('/', '/dashboard');
    Route::get('dashboard', [App\Http\Controllers\DashboardContoller::class, 'index'])->name('dashboard');
    
    // Logout
    // Sementara get dulu karena belum ada fitur logoutnya, sebatas test logout
    Route::get('logout', [App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');

    // for User
    Route::prefix('user')->group(function () {
        Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
        Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('{user}/get', [\App\Http\Controllers\UserController::class, 'get'])->name('user.get');
        Route::put('{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::delete('{user}/delete', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    });

    // for setting profile user auth
    Route::prefix('setting')->group(function(){
        Route::get('set-password', [App\Http\Controllers\SettingController::class, 'setPassword'])->name('settings.set-password');
        Route::get('set-profile', [App\Http\Controllers\SettingController::class, 'setProfile'])->name('settings.set-profile');
        Route::put('update-profile', [\App\Http\Controllers\SettingController::class, 'updateProfile'])->name('setting.update-profile');
        Route::put('update-password', [\App\Http\Controllers\SettingController::class, 'updatePassword'])->name('setting.update-password');
    });

});
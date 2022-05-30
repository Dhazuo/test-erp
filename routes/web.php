<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::middleware('auth:sanctum')->prefix('management')->name('management.')->group( function () {
    Route::get('/index', [ManagementController::class, 'index'])->name('index');
    Route::resource('product', ProductController::class);
    Route::post('confirm-delete', [MainController::class, 'confirmPassword'])->name('confirm_password');
});

Route::post('management-login', [AuthController::class, 'login'])->name('management_login');
Route::post('management-logout', [AuthController::class, 'logout'])->name('management_logout');

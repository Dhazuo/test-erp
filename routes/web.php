<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SalesPendingToDeleteController;

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
    Route::resource('product', ProductController::class)->middleware('role');
    Route::resource('user', UserController::class)->middleware('role:admin,manager,seller');
    Route::post('confirm-delete', [MainController::class, 'confirmPassword'])->name('confirm_password');
    Route::resource('sales', SalesController::class)->middleware('role');
    Route::post('sale-send-delete-request', [MainController::class, 'sendDeleteRequest'])->name('sales.send_delete_request');
    Route::name('sales.pending_to_delete.')->middleware('role:admin,manager,seller')->group(function () {
        Route::get('/sales/pending-to-delete/index', [SalesPendingToDeleteController::class, 'index'])->name('index');
        Route::get('/sales/pending-to-delete/{id}', [SalesPendingToDeleteController::class, 'show'])->name('show');
        Route::post('sales-pending-to-delete-reject', [SalesPendingToDeleteController::class, 'reject'])->name('reject');
        Route::post('sales-pending-to-delete-destroy', [SalesPendingToDeleteController::class, 'delete'])->name('destroy');
    });

    Route::name('notification.')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('index');
        Route::post('mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark_as_read');
        Route::post('mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark_all_as_read');
    });
});

Route::post('/management-login', [AuthController::class, 'login'])->name('management_login');
Route::post('/management-logout', [AuthController::class, 'logout'])->name('management_logout');

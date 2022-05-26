<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;

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
Route::middleware('auth:sanctum')->prefix('/management')->group(function () {
    Route::get('index', function (\Illuminate\Http\Request $request){
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == 'admin') {
            echo "Hola admin";
        }
        else if ($user->role == 'manager') {
            echo "Hola manager";
        }
        else {
            echo "Hola vendedor";
        }
    });
});

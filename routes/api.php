<?php

use App\Http\Authentication\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Bills\Controllers\BillsController;
use App\Http\Products\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Login User
Route::post('v1/login', [AuthenticationController::class, 'login']);


Route::middleware('auth:api')->prefix('v1/')->group(function () {
    Route::resource('bills', BillsController::class);
    Route::resource('products', ProductsController::class)->only(['index']);
    // Logout User
    Route::post('logout', [AuthenticationController::class, 'logout']);
});



<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceLocationController;
use App\Http\Controllers\FileController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!!!
|
*/


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('locations', LocationController::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::apiResource('devices', DeviceController::class);
    Route::get('device-locations', [DeviceLocationController::class, 'index'])->name('device-location.index');
    Route::post('device-locations', [DeviceLocationController::class, 'store'])->name('device-location.store');
    Route::get('get-location-by-device/{id}', [DeviceLocationController::class, 'getLocationByDevice'])->name('auth.getLocationByDevice');
});

Route::post('spreadsheet-import', [FileController::class, 'spreadsheetImport']);
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('reset-password',[AuthController::class, 'resetPassword'])->name('auth.resetPassword');

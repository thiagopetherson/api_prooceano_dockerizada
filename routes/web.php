<?php

use Illuminate\Support\Facades\Route;

// Scramble
use Dedoc\Scramble\Scramble;

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

Route::get('/', function () {
    return view('welcome');
});

Route::domain('localhost')->group(function () {
    Scramble::registerUiRoute('docs/api');
    Scramble::registerJsonSpecificationRoute('api.json');
});
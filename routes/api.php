<?php
use App\Http\Controllers\API\EcProductCategoriesController;
use App\Http\Controllers\API\RazenProject\ECProductController;
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
Route::get('/product/category', [EcProductCategoriesController::class, 'index']);
Route::get('/product/razen-project/product', [ECProductController::class, 'index']);

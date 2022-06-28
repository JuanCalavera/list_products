<?php

use App\Http\Controllers\ListProductsController;
use App\Http\Controllers\ProductsController;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('lista')->group(function (){
    Route::get('/', [ListProductsController::class, 'index']);
    Route::post('/add', [ListProductsController::class, 'create']);
    Route::get('/{listProducts}', [ListProductsController::class, 'show']);
    Route::post('/atualizar/{listProducts}', [ListProductsController::class, 'update']);
    Route::post('{listProducts}/adicionar-produto/', [ListProductsController::class, 'addProduct']);
    Route::delete('/deletar/{listProducts}', [ListProductsController::class, 'destroy']);
    Route::get('/duplicar/{listProducts}', [ListProductsController::class, 'duplicateList']);
});

Route::prefix('produtos')->group(function (){
    Route::get('/', [ProductsController::class, 'index']);
    Route::post('/add', [ProductsController::class, 'create']);
    Route::post('/atualizar/{products}', [ProductsController::class, 'update']);
    Route::get('/{products}', [ProductsController::class, 'show']);
    Route::delete('/deletar/{products}', [ProductsController::class, 'destroy']);
});

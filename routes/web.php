<?php

use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
})->middleware('isAuth');

Auth::routes();


/*
|-----------------------------------------------------------------------------
|HOME ROUTE (ROUTE)
|-----------------------------------------------------------------------------
*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*
|-----------------------------------------------------------------------------
|PRODUCT ROUTE (ROUTE)
|-----------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'home/product'
], function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('/import-csv', [ProductController::class, 'importCsv'])->name('product.import');
})->middleware('isAuth');


/*
|-----------------------------------------------------------------------------
|API ROUTE (ROUTE)
|-----------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'api/'
], function () {
    Route::get('products/search', [ApiProductController::class, 'search']);
    Route::get('products/', [ApiProductController::class, 'index']);
    Route::post('products/', [ApiProductController::class, 'store']);
    Route::get('products/{id}', [ApiProductController::class, 'show']);
    Route::put('products/{id}', [ApiProductController::class, 'update']);
    Route::delete('products/{id}', [ApiProductController::class, 'delete']);
});

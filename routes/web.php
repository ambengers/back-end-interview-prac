<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn() => redirect('/products'));


Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('new', [ProductController::class, 'store'])->name('store');
    Route::delete('{id}/delete', [ProductController::class, 'delete'])->name('delete');
});

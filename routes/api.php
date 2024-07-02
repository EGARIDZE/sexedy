<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Product\AttributeController;
use App\Http\Controllers\Admin\Product\OfferController;
use App\Http\Controllers\Admin\Product\ProductCareController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductDetailsController;
use App\Http\Controllers\Admin\Product\ProductFabricsController;
use Illuminate\Support\Facades\Route;

// Admin panel routes
Route::prefix('admin')->group(function () {

    // Category group
    Route::prefix('category')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');
    });

    // Brand group
    Route::prefix('brand')->group(function () {
        Route::get('', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::post('store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::put('update/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::delete('delete/{id}', [BrandController::class, 'destroy'])->name('admin.brand.delete');
    });

    // Product group
    Route::prefix('product')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('product-show/{id}', [ProductController::class, 'show'])->name('admin.product.show');
        Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.delete');

        // Product details group
        Route::prefix('product-show/{id}/details')->group(function () {
            Route::get('', [ProductDetailsController::class, 'index'])->name('admin.product.details.index');
            Route::post('store', [ProductDetailsController::class, 'store'])->name('admin.product.details.store');
            Route::delete('delete/{detail_id}', [ProductDetailsController::class, 'destroy'])->name('admin.product.details.delete');
        });

        // Product fabrics group
        Route::prefix('product-show/{id}/fabrics')->group(function () {
            Route::get('', [ProductFabricsController::class, 'index'])->name('admin.product.fabrics.index');
            Route::post('store', [ProductFabricsController::class, 'store'])->name('admin.product.fabrics.store');
            Route::delete('delete/{fabric_id}', [ProductFabricsController::class, 'destroy'])->name('admin.product.fabrics.delete');
        });

        // Product care group
        Route::prefix('product-show/{id}/cares')->group(function () {
            Route::get('', [ProductCareController::class, 'index'])->name('admin.product.cares.index');
            Route::post('store', [ProductCareController::class, 'store'])->name('admin.product.cares.store');
            Route::delete('delete/{care_id}', [ProductCareController::class, 'destroy'])->name('admin.product.cares.delete');
        });

        // Product offers group
        Route::prefix('product-show/{id}/offers')->group(function () {
            Route::get('', [OfferController::class, 'index'])->name('admin.product.offers.index');
        });

        // Product attributes group
        Route::prefix('attribute')->group(function () {
            Route::get('', [AttributeController::class, 'index'])->name('admin.product.attribute.index');
            Route::post('store', [AttributeController::class, 'store'])->name('admin.product.attribute.store');
            Route::delete('delete/{attribute_id}', [AttributeController::class, 'destroy'])->name('admin.product.attribute.delete');
        });
    });
});
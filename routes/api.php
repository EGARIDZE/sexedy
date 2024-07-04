<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Product\AttributeController;
use App\Http\Controllers\Admin\Product\AttributeOptionController;
use App\Http\Controllers\Admin\Product\OfferController;
use App\Http\Controllers\Admin\Product\ProductCareController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductDetailsController;
use App\Http\Controllers\Admin\Product\ProductFabricsController;
use Illuminate\Support\Facades\Route;

// Admin panel routes
Route::prefix('admin')->group(function () {

    // Category group
    Route::prefix('category')->name('admin.category.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
    });

    // Brand group
    Route::prefix('brand')->name('admin.brand.')->group(function () {
        Route::get('', [BrandController::class, 'index'])->name('index');
        Route::post('store', [BrandController::class, 'store'])->name('store');
        Route::put('update/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [BrandController::class, 'destroy'])->name('delete');
    });

    // Product group
    Route::prefix('product')->name('admin.product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('product-show/{id}', [ProductController::class, 'show'])->name('show');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('delete');

        // Product attributes group
        Route::prefix('attribute')->name('attribute.')->group(function () {
            Route::get('', [AttributeController::class, 'index'])->name('index');
            Route::post('store', [AttributeController::class, 'store'])->name('store');
            Route::delete('delete/{attribute_id}', [AttributeController::class, 'destroy'])->name('delete');
        });

        // Product details group
        Route::prefix('product-show/{id}/details')->name('details.')->group(function () {
            Route::get('', [ProductDetailsController::class, 'index'])->name('index');
            Route::post('store', [ProductDetailsController::class, 'store'])->name('store');
            Route::delete('delete/{detail_id}', [ProductDetailsController::class, 'destroy'])->name('delete');
        });

        // Product fabrics group
        Route::prefix('product-show/{id}/fabrics')->name('fabrics.')->group(function () {
            Route::get('', [ProductFabricsController::class, 'index'])->name('index');
            Route::post('store', [ProductFabricsController::class, 'store'])->name('store');
            Route::delete('delete/{fabric_id}', [ProductFabricsController::class, 'destroy'])->name('delete');
        });

        // Product care group
        Route::prefix('product-show/{id}/cares')->name('cares.')->group(function () {
            Route::get('', [ProductCareController::class, 'index'])->name('index');
            Route::post('store', [ProductCareController::class, 'store'])->name('store');
            Route::delete('delete/{care_id}', [ProductCareController::class, 'destroy'])->name('delete');
        });

        // Product offers group
        Route::prefix('product-show/{id}/offers')->name('offers.')->group(function () {
            Route::get('', [OfferController::class, 'index'])->name('index');
            Route::get('offer-show/{offer_id}', [OfferController::class, 'show'])->name('show');
            Route::post('store', [OfferController::class, 'store'])->name('store');
            Route::delete('delete/{offer_id}', [OfferController::class, 'destroy'])->name('delete');
        });

        Route::prefix('product-show/{id}/offers/offer-show/{offer_id}/option')->name('offers.show.option.')->group(function () {
            Route::get('', [AttributeOptionController::class, 'index'])->name('index');
            Route::get('get-attributes', [AttributeOptionController::class, 'getAttributesForOptions'])->name('attributes');
            Route::post('store', [AttributeOptionController::class, 'store'])->name('store');
            Route::delete('delete/{name}', [AttributeOptionController::class, 'destroy'])->name('delete');
        });
    });
});
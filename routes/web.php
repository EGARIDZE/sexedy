<?php

use Illuminate\Support\Facades\Route;

// Group of routes for the administrative panel
Route::prefix('admin')->group(function () {

    //Category group
    Route::prefix('category')->group(function () {
        Route::get('/', function () {
            return view('admin.category.index');
        })->name('category.index');
        Route::get('/create', function () {
            return view('admin.category.create');
        })->name('category.create');
        Route::get('/update/{id}', function ($id) {
            return view('admin.category.update', ['id' => $id]);
        })->name('category.update');
    });

    //Brand group
    Route::prefix('brand')->group(function () {
        Route::get('/', function () {
            return view('admin.brand.index');
        })->name('brand.index');
        Route::get('/create', function () {
            return view('admin.brand.create');
        })->name('brand.create');
        Route::get('/update/{id}', function ($id) {
            return view('admin.brand.update', ['id' => $id]);
        })->name('brand.update');
    });

    //Product group
    Route::prefix('product')->group(function () {
        Route::get('/', function () {
            return view('admin.product.index');
        })->name('product.index');
        Route::get('/create', function () {
            return view('admin.product.create');
        })->name('product.create');
        Route::get('/product-show/{id}', function ($id) {
            return view('admin.product.product-show', ['id' => $id]);
        })->name('product.show');

        Route::prefix('/product-show/{id}/details')->group(function () {
            Route::get('/', function () {
                return view('admin.product.details.index');
            })->name('product.details.index');
        });

        Route::prefix('/product-show/{id}/fabrics')->group(function () {
            Route::get('/', function () {
                return view('admin.product.fabrics.index');
            })->name('product.fabrics.index');
        });

        Route::prefix('/product-show/{id}/cares')->group(function () {
            Route::get('/', function () {
                return view('admin.product.cares.index');
            })->name('product.cares.index');
        });

        Route::prefix('/product-show/{id}/offers')->group(function () {

            Route::get('/', function () {
                return view('admin.product.offers.index');
            })->name('product.offers.index');

            Route::get('/{offer_id}', function ($id, $offer_id) {
                return view('admin.product.offers.offer-show', ['id' => $id, 'offer_id' => $offer_id]);
            })->name('product.offers.show');
        });

        Route::get('/attribute', function () {
            return view('admin.product.attributes.attribute');
        })->name('product.attribute');
    });
});
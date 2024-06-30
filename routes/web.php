    <?php

    use App\Http\Controllers\Admin\Product\OfferController;
    use App\Http\Controllers\Admin\ProductController;
    use Illuminate\Support\Facades\Route;

    // Группа маршрутов для административной панели
    Route::prefix('admin')->group(function () {

        Route::get('/auth', function () {
            return view('admin.auth');
        })->name('auth');

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');


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

        Route::prefix('brand')->group(function () {
            Route::get('', function () {
                return view('admin.brand.index');
            })->name('brand.index');
            Route::get('create', function () {
                return view('admin.brand.create');
            })->name('brand.create');
            Route::get('edit/{id}', function ($id) {
                return view('admin.brand.edit', ['id' => $id]);
            });
        });


        Route::prefix('product')->group(function () {

            Route::get('', function () {
                return view('admin.product.index');
            })->name('product.index');

            Route::get('create', function () {
                return view('admin.product.create');
            })->name('product.create');

            Route::get('product-show/{id}', function ($id) {
                return view('admin.product.product-show', ['id' => $id]);
            });

            Route::prefix('product-show/{id}/details')->group(function () {
                Route::get('', function () {
                    return view('admin.product.details.index');
                })->name('product-show.details');
            });

            Route::prefix('product-show/{id}/fabrics')->group(function () {
                Route::get('', function () {
                    return view('admin.product.fabrics.index');
                })->name('product-show.fabric');
            });

            Route::prefix('product-show/{id}/cares')->group(function () {
                Route::get('', function () {
                    return view('admin.product.cares.index');
                })->name('product-show.cares');
            });

            Route::prefix('product-show/{id}/offers')->group(function () {
                Route::get('', function () {
                    return view('admin.product.offers.index');
                });
            });

            Route::get('attribute', function () {
                return view('admin.product.attributes.attribute');
            })->name('product.attribute');
        });
    });
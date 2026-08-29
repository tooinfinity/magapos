<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\GeneralSettingController;
use App\Http\Controllers\Dashboard\ModeratorController;
use App\Http\Controllers\Dashboard\MoneyBoxController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProviderController;
use App\Http\Controllers\Dashboard\PurchaseController;
use App\Http\Controllers\Dashboard\SaleController;
use App\Http\Controllers\Dashboard\SpendingController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('/', function () {
            return view('auth.login');
        });

        Auth::routes(['register' => false]);

        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::resource('/moderator', ModeratorController::class)->except(['show']);
            Route::get('/moderator/profile', [ModeratorController::class, 'profile'])->name('moderator.profile');

            Route::resource('/category', CategoryController::class)->except(['show']);

            Route::resource('/product', ProductController::class)->except(['show']);
            Route::get('/searchsale', [ProductController::class, 'searchsale'])->name('product.searchsale');
            Route::get('/searchpurchase', [ProductController::class, 'searchpurchase'])->name('product.searchpurchase');
            Route::get('/addproduct', [ProductController::class, 'addproduct'])->name('product.addproduct');
            Route::get('/barcode', [ProductController::class, 'barcode']);
            Route::put('/updateprice/{id}', [ProductController::class, 'updateprice']);

            Route::put('/paymentdue/{id}', [SaleController::class, 'paymentdue']);
            Route::put('/paymentduep/{id}', [PurchaseController::class, 'paymentduep']);
            Route::resource('/sale', SaleController::class);
            Route::resource('/purchase', PurchaseController::class);

            Route::resource('/client', ClientController::class)->except(['show']);
            Route::get('/client/detail/{id}', [ClientController::class, 'saledetail'])->name('client.detail');

            Route::resource('/provider', ProviderController::class)->except(['show']);
            Route::get('/provider/detail/{id}', [ProviderController::class, 'purchasedetail'])->name('provider.detail');

            Route::post('/newspend', [SpendingController::class, 'store']);
            Route::put('/updatespend/{id}', [SpendingController::class, 'updatespend']);
            Route::resource('/spending', SpendingController::class)->except(['show']);

            Route::get('/moneybox', [MoneyBoxController::class, 'index'])->name('moneybox');

            Route::resource('/generalsetting', GeneralSettingController::class)->except(['show', 'update', 'destroy', 'create', 'edit']);
        });
    }
);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

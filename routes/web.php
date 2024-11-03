<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Middleware\Auth\CheckUserLogin;
use App\Models\account;
use App\Models\Product;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

Route::group(['prefix' => '/auth'], function () {
    // social login
    Route::get('/redirection/{provider}', [AccountController::class, 'authProviderRedirect'])->name('account.redirect');
    Route::get('/{provider}/callback', [AccountController::class, 'socialAuthentication'])->name('account.callback');

    // account
    Route::get('/account/login', [AccountController::class, 'index'])
        ->name('account.index')
        ->middleware(CheckUserLogin::class);
    Route::get('/account/register', [AccountController::class, 'index'])
        ->name('account.register')
        ->middleware(CheckUserLogin::class);
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

Route::group(['prefix' => '/category'], function () {
    Route::get('/{categoryName}', [CategoryController::class, 'index'])->name('category.index');

    // Route::get ('/detail-product/{id}', function () {
    //     return view('products.detail-product');
    // })->name('product.detail-product');
});


Route::group(['prefix' => '/product'], function () {
    Route::get('/detail-product/{name}-{id}', [ProductController::class, 'detail'])
        ->name('product.detail')
        ->where('id', '[0-9]+')
        ->where('name', '.*');
});

Route::group(['prefix' => '/order'], function () {
    Route::get('/list-order', [OrderController::class, 'index'])->name('order.index');
});

Route::group(['prefix' => '/user'], function () {
    Route::get('/', function () {
        return redirect('/user/index');
    });
    Route::get('/index', function () {
        return view('customers.index');
    });
    // Sử dụng Livewire cho các trang khác nhau
    // Route::get('/previous-orders', PreviousOrders::class)->name('user.previous-orders');
    // Route::get('/favourite-orders', FavouriteOrders::class)->name('user.favourite-orders');
    // Route::get('/address', Address::class)->name('user.address');
    // Route::get('/my-account/detail', MyAccountDetail::class)->name('user.my-account.detail');
    // Route::get('/my-account/reset-password', ResetPassword::class)->name('user.my-account.reset-password');
    // Route::get('/my-account/delete', DeleteAccount::class)->name('user.my-account.delete');
});
Route::fallback(function () {
    abort(404);
});
<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\Auth\CheckUserLogin;
use App\Http\Middleware\Auth\CheckUserWithoutLogin;
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
    Route::get('/{categoryName}/{page}', [CategoryController::class, 'index'])->name('category.index');

    // Route::get ('/detail-product/{id}', function () {
    //     return view('products.detail-product');
    // })->name('product.detail-product');
});


Route::group(['prefix' => '/product'], function () {
    Route::get('/list-product', [ProductController::class, 'listProduct'])->name('product.list-product');
    Route::get('/detail-product/{slug}', [ProductController::class, 'detail'])
        ->name('product.detail');
});

Route::group(['prefix' => '/order', 'middleware' => [CheckUserWithoutLogin::class]], function () {
    Route::get('/list-order', action: [OrderController::class, 'index'])->name('order.index');
});

Route::group(['prefix' => '/user'], function () {
    Route::get('/', function () {
        return redirect('/user/index');
    });
    Route::get('/index', [UserController::class,'index'])->name('user.index');

});
Route::delete('/delete-address/{id}', [UserController::class, 'deleteAddress'])->name('delete.address');

Route::fallback(function () {
    abort(404);
});
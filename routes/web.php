<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Middleware\Auth\CheckUserLogin;
use App\Models\account;
use App\Models\Product;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/'], function () {
    Route::get('/',[HomeController::class,"index"])->name("home.index");

});

Route::group(['prefix' => '/auth'], function () {

    // social login
    Route::get('/redirection/{provider}', [AccountController::class, 'authProviderRedirect'])->name('account.redirect');
    Route::get('/{provider}/callback', [AccountController::class, 'socialAuthentication'])->name('account.callback');

    // account
    Route::get('/account/login', [AccountController::class, 'index'])->name('account.index')->middleware(CheckUserLogin::class);
    Route::get('/account/register', [AccountController::class, 'index'])->name('account.register')->middleware(CheckUserLogin::class);
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

Route::group(['prefix' => '/category'], function () {
    Route::get('/{categoryName}', [CategoryController::class, 'index'])->name('category.index');

    Route::get ('/detail-product/{id}', function () {
        return view('products.detail-product');
    });
});

Route::group(['prefix'=>'/users'],function(){
    Route::get('/',function(){
        return redirect('/users/index');
    });
    Route::get('/index',function(){
        return view('users.index');
    });


});
Route::fallback(function () {
    abort(404);
});
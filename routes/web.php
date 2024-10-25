<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;
// use App\Database\DbConnection;

// $db=DbConnection::getInstance()->getConnection();


Route::group(['prefix' => '/'], function () {
    Route::get('/',[HomeController::class,"index"])->name("home.index");

    // account
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
});

Route::group(['prefix' => '/product'], function () {
    Route::get('/', function () {
        return view('products.welcome');
    });

    Route::get ('/detail-product/{id}', function () {
        return view('products.detail-product');
    });
});
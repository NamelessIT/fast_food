<?php

use App\Http\Controllers\Account\AccountController;
use App\Models\account;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
// use App\Database\DbConnection;

// $db=DbConnection::getInstance()->getConnection();

Route::get('/', function () {
    // $all_account = account::all();
    $all_products = Product::all();

    // dd ($all_products);

    return view('products.welcome', [
        'all_products' => $all_products]);
});

Route::group(['prefix' => '/'], function () {
    // account
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

Route::group(['prefix' => '/product'], function () {
    Route::get('/', function () {
        return view('products.welcome');
    });

    Route::get ('/detail-product/{id}', function () {
        return view('products.detail-product');
    });
});
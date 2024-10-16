<?php

use App\Http\Controllers\accountController;
use Illuminate\Support\Facades\Route;
// use App\Database\DbConnection;

// $db=DbConnection::getInstance()->getConnection();

Route::get('/', function () {
    return view('products.welcome');
});

Route::get('/account',[accountController::class,'index']);
Route::get('/username',[accountController::class,'getUsername'])->name('getUsername');
Route::post('/signup', [accountController::class, 'signup'])->name('signup');
Route::post('/login', [accountController::class, 'login'])->name('login');

Route::group(['prefix' => '/product'], function () {
    Route::get('/', function () {
        return view('products.welcome');
    });

    Route::get ('/detail-product/{id}', function () {
        return view('products.detail-product');
    });
});
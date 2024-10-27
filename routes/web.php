<?php

use App\Http\Controllers\Account\AccountController;
use App\Models\account;
use App\Models\Product;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Address;
use App\Livewire\DeleteAccount;
use App\Livewire\FavouriteOrders;
use App\Livewire\MyAccountDetail;
use App\Livewire\PreviousOrders;
use App\Livewire\ResetPassword;
// use App\Database\DbConnection;

// $db=DbConnection::getInstance()->getConnection();

Route::group(['prefix' => '/'], function () {
    Route::get('/',[HomeController::class,"index"])->name("home.index");
    
    // account
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

Route::group(['prefix' => '/product'], function () {
    /*Route::get('/', function () {
        return view('products.welcome');
    });*/
    Route::get('/', [ProductController::class, 'index'])->name('product.index');

    Route::get ('/detail-product/{id}', function () {
        return view('products.detail-product');
    });
});

Route::group(['prefix'=>'/user'],function(){
    Route::get('/',function(){
        return redirect('/user/index');
    });
    Route::get('/index',function(){
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

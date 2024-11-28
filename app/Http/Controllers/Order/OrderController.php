<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;

class OrderController
{
    public function index () {
        return view('order.index');
    }
    public function detail($id){
        return view('order.detail-order.index', [
            'id' => $id
        ]);
    }
}
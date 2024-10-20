<?php

namespace App\Http\Controllers;

use App\Models\ReceiptDetail;
abstract class Controller
{
    //
}
class ReceiptDetailController extends Controller
{
    public function index()
    {
        $receiptDetail = ReceiptDetail::all();  // Lấy tất cả dữ liệu từ bảng products
        return view('receiptDetail.index', compact('receiptDetail'));  // Trả về view kèm dữ liệu
    }
}
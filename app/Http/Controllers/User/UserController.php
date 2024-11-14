<?php

namespace App\Http\Controllers\User;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class UserController
{
    public function index () {
        return view ('users.index', [
        ]);
    }
    public function deleteAddress($id) {
        $address = CustomerAddress::find($id);
        if ($address) {
            $address->delete();
            return response()->json(['success' => true, 'message' => 'Địa chỉ đã bị xóa']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy địa chỉ']);
    }
    
}
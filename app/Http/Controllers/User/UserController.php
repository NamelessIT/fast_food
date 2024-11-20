<?php

namespace App\Http\Controllers\User;
use App\Models\CustomerAddress;
use App\Models\Bill;
use Illuminate\Http\Request;

class UserController
{
    public function index () {
        return view ('users.index', [
        ]);
    }
public function deleteAddress($id)
{
    $address = CustomerAddress::find($id);

    if (!$address) {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy địa chỉ']);
    }

    // Kiểm tra nếu địa chỉ này đã được sử dụng trong bảng Bill
    $billExists = Bill::where('id_address', $id)->exists();

    if ($billExists) {
        // Chuyển status về 0 thay vì xóa
        $address->status = 0;
        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'Địa chỉ được sử dụng trong hóa đơn nên đã chuyển trạng thái sang không hoạt động'
        ]);
    } else {
        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Địa chỉ đã bị xóa'
        ]);
    }
}

    
}
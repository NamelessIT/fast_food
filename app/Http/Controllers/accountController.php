<?php

namespace App\Http\Controllers;

use App\Database\DbConnection;
use Date;
use Illuminate\Http\Request;
use App\Models\account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\View\View;
class accountController extends Controller
{
    //
    public function index(){
        return view("accounts.index");
    }
    public function signup(Request $request)
    {
        // Lấy dữ liệu từ request
        $email=$request->input("email_Sign");
        $username = $request->input("username_Sign");
        $password = Hash::make($request->input('password_Sign')); // Mã hóa mật khẩu
        $day = Carbon::now(); // Sử dụng Carbon để lấy ngày hiện tại

        // Chèn dữ liệu vào bảng account_taikhoan bằng Eloquent
        Account::create([
            'Email'=>$email,
            'Username' => $username,
            'Password' => $password, // Mã hóa trước khi lưu
            'RoleNameID' => 1, // Giả sử 1 là Role mặc định
            'dateLogin' => $day
        ]);

        // Đặt session username
        $this->setUsername($request, $username);

        // Trả về view
        return view('products.welcome');
    }
    public function login(Request $request)
    {
            $this->getUsername($request);
            return view('products.welcome');
    }
    public function setUsername(Request $request,$username){
        Session::put('username', $username);
    }
    public function hasSession(Request $request)
    {
        if ($request->session()->has('username')) {
            return true;
        } else {
            return false;
        }
    }
    public function forgetSession(Request $request)
    {
        $request->session()->forget('username');
    }
    public function getUsername(Request $request)
    {
        $name = Session::get('username');

        return view('components/layouts.Header', ['name' => $name]);
    }

    public function checkEmail(Request $request)
    {
        // Kiểm tra email có tồn tại hay không
        $exists = account::where('email', $request->email)->exists();

        // Trả về kết quả dưới dạng JSON
        if ($exists) {
            return response()->json(['exists' => true, 'message' => 'Email đã tồn tại']);
        } else {
            return response()->json(['exists' => false, 'message' => 'Email hợp lệ']);
        }
    }
    public function checkAccount(Request $request)
    {
        // Lấy email và password từ request
        $email = $request->input('email');
        $password = $request->input('password');

        // Tìm tài khoản dựa vào email
        $account = Account::where('Email', $email)->first();

        if ($account) {
            // Kiểm tra mật khẩu
            if (Hash::check($password, $account->Password)) {
                // Nếu email và password trùng khớp
                return response()->json(['valid' => true, 'message' => 'Tài khoản hợp lệ'], 200);
            } else {
                // Nếu mật khẩu không khớp
                return response()->json(['valid' => false, 'message' => 'Mật khẩu không đúng'], 200);
            }
        } else {
            // Nếu không tìm thấy tài khoản với email đó
            return response()->json(['valid' => false, 'message' => 'Tài khoản không tồn tại'], 200);
        }
    }

}

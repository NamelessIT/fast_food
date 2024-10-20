<?php

namespace App\Http\Controllers;

use App\Database\DbConnection;
use Date;
use Illuminate\Http\Request;
use App\Models\account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class accountController extends Controller
{
    //
    public function index(){
        return view("accounts.index");
    }
    public function signup(Request $request)
    {
        $username = $request->input("username_Sign");
        $password = $request->input('password_Sign');
        $day = now();
    
        // Chèn dữ liệu vào bảng account_taikhoan
        mysqli_query(DbConnection::getInstance()->getConnection(), "INSERT INTO account_taikhoan (Username, Password, RoleNameID, dateLogin) VALUES ('$username', '$password', 1, '$day')");
    
        $this->setUsername($request,$username);
    
        return view('products.welcome');
    }
    public function login(Request $request)
    {
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

        return view('products.welcome', ['name' => $name]);
    }

}

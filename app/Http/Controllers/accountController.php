<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class accountController extends Controller
{
    //
    public function index(){
        return view("accounts.index");
    }
    public function signup(Request $request)
    {

            return view('products.welcome');

    }
    public function login(Request $request)
    {
            return view('products.welcome');
    }
}

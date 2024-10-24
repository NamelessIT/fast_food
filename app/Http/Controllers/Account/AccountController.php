<?php

namespace App\Http\Controllers\Account;

use Auth;
use Illuminate\Http\Request;

class AccountController
{
    public function index()
    {
        return view('accounts.index');
    }

    public function logout () {
        Auth::logout();
        return redirect('/');
    }
}
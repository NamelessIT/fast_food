<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

class AccountController
{
    public function index()
    {
        return view('accounts.index');
    }
}
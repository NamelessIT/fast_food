<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

class UserController
{
    public function index () {
        return view ('users.index', [

        ]);
    }
}
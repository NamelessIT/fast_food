<?php

namespace App\Http\Controllers\Account;

use App\Models\account;
use App\Models\Customer;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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

    public function authProviderRedirect ($provider) {
        // dd ($provider);
        if ($provider) {
            return Socialite::driver($provider)->redirect ();
        }
        abort(404);
    }

    public function socialAuthentication ($provider) {
        try {
            if ($provider) {
                // dd ($provider);
                $socialUser = Socialite::driver($provider)->user();
                // dd ($socialUser);
                $email = $socialUser->email;
                $avatar = $socialUser->avatar;
                $name = $socialUser->name;
                $base64 = base64_encode(file_get_contents ($avatar));
                
                // dd ($name, $email, $base64);
                
                $account = account::where('email', $email)->first();

                // dd ($account);

                if ($account) {
                    Auth::login($account);
                    return redirect()->route('home.index');
                }

                $customer = Customer::create([
                    'full_name' => $name
                ]);

                if (!$customer) {
                    dd ("thất bại");
                }

                // dd ($customer);
                
                $customer_id = $customer->id;

                $account = account::create([
                    'id_user' => $customer_id,
                    'email' => $email,
                    'avatar' => $base64
                ]);

                Auth::login($account);
                return redirect()->route('home.index');

                // dd ($name);
            }
            abort(404);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
<?php

namespace App\Livewire\Account;

use App\Mail\OtpMail;
use App\Models\account;
use App\Models\Customer;
use App\Models\Order;
use Cache;
use Carbon\Carbon;
use Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;

class FormRegister extends Component
{
    public $email = '';
    public $fullname = '';
    public $phoneNumber = '';
    public $username = '';
    public $password = '';

    use WithFileUploads;
    public $avatar = '';

    public $otp = '';

    public function register()
    {
        $request = new \App\Http\Requests\Account\FormRegister();
        $this->validate($request->rules($this->email), $request->messages());

        // dd (Cache::get('otp_' . $this->email));
        if (!$this->verifyOtp()) {
            return;
        }


        $base64 = null;
        // dd ($this->avatar);
        if ($this->avatar != "") {
            $base64 = base64_encode(file_get_contents($this->avatar->getRealPath()));
        }
        // dd($base64);

        $customer = Customer::create([
            'full_name' => $this->fullname,
            'phone' => $this->phoneNumber,
        ]);

        $idUser = $customer->id;

        $account = new account([
            'user_id' => $idUser,
            'email' => $this->email,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'avatar' => $base64,
        ]);
        $customer->account()->save($account);
        
        // account::create ([
        //     'id_user' => $idUser,
        //     'email' => $this->email,
        //     'username' => $this->username,
        //     'password' => Hash::make($this->password),
        //     'avatar' => $base64
        // ]);

        Order::create([
            "id_customer" =>$idUser,
            "created_at" =>Carbon::now(),
            "updated_at"=> Carbon::now ()
        ]);

        return redirect()->route('account.index')->with('success', 'Đăng kí thành công');
    }

    public function sendOTP()
    {
        $this->validate(
            [
                'email' => 'required|email|unique:accounts',
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Vui lòng nhập đúng email',
                'email.unique' => 'Email đã tồn tại',
            ],
        );
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $this->email, $otp, now()->addSeconds(300));
        
        Mail::to($this->email)->send(new OtpMail($otp));
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Đã gửi mã OTP đến email của bạn',
        ]);
    }

    public function verifyOtp()
    {
        $cachedOtp = Cache::get('otp_' . $this->email);
        if ($cachedOtp && $cachedOtp == $this->otp) {
            Cache::forget('otp_' . $this->email);
            return true;
        }

        return false;
    }

    public function render()
    {
        return view('livewire.account.form-register');
    }
}
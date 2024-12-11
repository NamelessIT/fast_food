<?php

namespace App\Livewire\Account;

use App\Mail\OtpMail;
use Cache;
use Livewire\Component;
use Mail;

class FormForgotPassword extends Component
{
    public $email;
    public $otp;

    public function continue () {
        // dd (Cache::get('otp_' . $this->email));
        $this->validate(
            [
                'email' => 'required|email',
                'otp' => 'required',
            ],
            [
                'email.required' => 'Vui lòng nhập email của bạn',
                'email.email' => 'Email không hợp lệ',
                'otp.required' => 'Vui lòng nhập OTP',
            ]
        );

        if (!$this->verifyOtp()) {
            return;
        }

        return redirect()->route('account.reset-password', ['email' => $this->email]);
    }

    public function sendOTP()
    {
        $this->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
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
        return view('livewire.account.form-forgot-password');
    }
}
<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login;
use Illuminate\Validation\ValidationException;

class CustomLogin extends Login
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getLoginlFormComponent(),
                        $this->getPasswordFormComponent(),
                        //$this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getLoginlFormComponent(): Component
    {
        return TextInput::make('login')
            ->label(__('Username / Email'))
            ->rules(['required'])
            ->validationMessages([
                'required' => 'Bạn chưa nhập username hoặc email'
            ])
            ->autocomplete()
            ->markAsRequired()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('Password'))
            ->rules(['required'])
            ->password()
            ->revealable()
            ->markAsRequired()
            ->validationMessages([
                'required' => 'Bạn chưa nhập mật khẩu',
            ])
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];

        // Kiểm tra thêm `status` và `deleted_at`
        $user = \App\Models\Account::where($login_type, $data['login'])
            ->where('status', 1) // Status = 1 (active)
            //->whereNull('deleted_at') // Không bị xóa mềm
            ->first();

        if (!$user) {
            $this->throwFailureValidationException();
        }

        return $credentials;
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('Username/Email hoặc mật khẩu không chính xác. Vui lòng thử lại.'),
        ]);
    }
}

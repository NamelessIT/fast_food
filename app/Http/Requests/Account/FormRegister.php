<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:accounts,email'],
            'fullname' => ['required', 'regex:/^[a-zA-ZÀ-ỹ\s]*$/', 'min:3'],
            'phoneNumber' => ['required', 'numeric', 'digits:10', Rule::unique('customers', 'phone'), Rule::unique('employees', 'phone')],
            'username' => 'required|unique:accounts,username',
            'password' => 'required|min:6',
            'avatar' => 'image|max:3072'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',

            'fullname.required' => 'Họ tên không được để trống',
            'fullname.regex' => 'Tên không chính xác',

            'phoneNumber.required' => 'Số điện thoại không được để trống',
            'phoneNumber.numeric' => 'Số điện thoại phải là số',
            'phoneNumber.digits' => 'Số điện thoại không đúng định dạng',
            'phoneNumber.unique' => 'Số điện thoại đã tồn tại',

            'username.required' => 'Tên đăng nhập không được để trống',
            'username.unique' => 'Tên đăng nhập đã tồn tại',

            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',

            'avatar.image' => 'Ảnh đại diện phải là hình ảnh',
            'avatar.max' => 'Ảnh đại diện phải nhỏ hơn 3MB'            
        ];
    }
}
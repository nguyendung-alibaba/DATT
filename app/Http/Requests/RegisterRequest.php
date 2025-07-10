<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả users gửi request này
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.unique' => 'Email này đã được sử dụng',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            // Thêm các message tuỳ chỉnh khác
        ];
    }
}
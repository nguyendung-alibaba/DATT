<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //
    public function register()
    {
        // Trả về giao diện đăng ký
        return view('auth.register'); // resources/views/auth/register.blade.php
    }
public function postRegister(RegisterRequest $request)
{
    $validatedData = $request->validated();
    
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);
    // Đăng nhập người dùng sau khi đăng ký thành công
    auth()->login($user);

    return redirect('login')->with('success', 'Đăng ký thành công!');
}
public function login()
{
    // Trả về giao diện đăng nhập
    return view('auth.login'); // resources/views/auth/login.blade.php
}
public function postLogin(LoginRequest $request){
    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        // Đăng nhập thành công, chuyển hướng đến trang chủ
        return redirect('/')->with('success', 'Đăng nhập thành công!');
    } else {
        // Đăng nhập thất bại, trả về thông báo lỗi
        return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
    }
}
public function logout()
{
    auth()->logout();
    return redirect('login')->with('success', 'Đăng xuất thành công!');
}
}

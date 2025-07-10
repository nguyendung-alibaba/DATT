<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() { 
        return redirect()->route('admin.dashboard');
     }
    public function taikhoan() { return redirect()->route('admin.taikhoan'); }
    public function sanpham() { return redirect()->route('admin.sanpham'); }
    public function donhang() { return redirect()->route('admin.donhang'); }
    public function danhmuc() { return redirect()->route('admin.danhmuc'); }
    public function khachhang() { return redirect()->route('admin.khachhang'); }
    public function voucher() { return redirect()->route('admin.voucher'); }
    public function baocao() { return redirect()->route('admin.baocao'); }
}

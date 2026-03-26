<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetDirect(Request $request): RedirectResponse
    {
        return back()->with('error', 'Chức năng đặt lại mật khẩu trực tiếp đã bị tắt để bảo vệ tài khoản. Vui lòng dùng hỗ trợ trực tuyến để được trợ giúp.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function resetDirect(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        return redirect('/login')->with('success', 'Đổi mật khẩu thành công!');
    }
}
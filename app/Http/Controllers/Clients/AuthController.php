<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember_login'))) {
            $request->session()->regenerate();

            $response = redirect()
                ->route('home')
                ->with('success', 'Đăng nhập thành công!');

            return $this->withRememberedEmailCookie($request, $response);
        }

        $response = back()
            ->withInput()
            ->with('error', 'Email hoặc mật khẩu không đúng');

        return $this->withRememberedEmailCookie($request, $response);
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Vui long nhap ho va ten.',
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong dung dinh dang.',
            'email.unique' => 'Email nay da ton tai. Vui long dung email khac hoac dang nhap.',
            'password.required' => 'Vui long nhap mat khau.',
            'password.min' => 'Mat khau phai co it nhat 8 ky tu.',
            'password.confirmed' => 'Xac nhan mat khau khong khop.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function logout(Request $request): RedirectResponse
    {
        if ($user = $request->user()) {
            $user->forceFill([
                'remember_token' => Str::random(60),
            ])->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Đã đăng xuất thành công!');
    }

    private function withRememberedEmailCookie(Request $request, RedirectResponse $response): RedirectResponse
    {
        if ($request->boolean('remember_login') && filled($request->email)) {
            return $response->cookie(
                Cookie::make('remembered_email', (string) $request->input('email'), 60 * 24 * 30)
            );
        }

        return $response->withoutCookie('remembered_email');
    }
}

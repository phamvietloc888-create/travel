<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 👉 Hiển thị profile + lịch sử đặt tour
    public function index()
    {
        $user = Auth::user();

        // load lịch sử booking của user
        $bookings = $user->bookings()
            ->with('tour')      // load tour liên quan
            ->latest()
            ->get();

        return view('profile.user', compact('user', 'bookings'));
    }

    // 👉 Update profile
  public function update(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255|unique:users,email,' . auth()->id(),
        'phone'   => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);

    auth()->user()->update(
        $request->only('name', 'email', 'phone', 'address')
    );

    return back()->with('success', 'Cập nhật profile thành công');
}

    public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Mật khẩu hiện tại không đúng');
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('success', 'Đổi mật khẩu thành công');
}
}

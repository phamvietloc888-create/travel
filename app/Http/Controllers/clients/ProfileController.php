<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected function bookingQueryForUser()
    {
        $user = Auth::user();

        return Booking::query()
            ->with('tour')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id);

                if (!empty($user->email)) {
                    $query->orWhere(function ($fallbackQuery) use ($user) {
                        $fallbackQuery->whereNull('user_id')
                            ->where('customer_email', $user->email);
                    });
                }
            });
    }

    protected function profilePayload(): array
    {
        $user = Auth::user();
        $bookings = $this->bookingQueryForUser()
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return compact('user', 'bookings');
    }

    public function index()
    {
        return view('profile.user', $this->profilePayload());
    }

    public function bookings()
    {
        if (Booking::supportsCustomerNotifications()) {
            $this->bookingQueryForUser()
                ->whereNotNull('customer_notice')
                ->whereNull('customer_notice_read_at')
                ->update(['customer_notice_read_at' => now()]);
        }

        return view('profile.bookings', $this->profilePayload());
    }

    public function wishlist()
    {
        return view('profile.user', $this->profilePayload());
    }

    public function cancelBooking(Booking $booking)
    {
        $ownedBooking = $this->bookingQueryForUser()
            ->whereKey($booking->id)
            ->firstOrFail();

        if (!in_array($ownedBooking->booking_status, ['PENDING', 'CONFIRMED'], true)) {
            return back()->with('error', 'Booking này không thể hủy.');
        }

        $ownedBooking->update([
            'booking_status' => 'CANCELED',
        ]);

        return back()->with('success', 'Đã hủy tour thành công.');
    }

    public function openNotification(Booking $booking)
    {
        $ownedBooking = $this->bookingQueryForUser()
            ->whereKey($booking->id)
            ->firstOrFail();

        if (Booking::supportsCustomerNotifications() && $ownedBooking->hasUnreadCustomerNotice()) {
            $ownedBooking->update([
                'customer_notice_read_at' => now(),
            ]);
        }

        return redirect()->route('booking.confirmation', $ownedBooking);
    }

    public function deleteBooking(Booking $booking)
    {
        $ownedBooking = $this->bookingQueryForUser()
            ->whereKey($booking->id)
            ->firstOrFail();

        if ($ownedBooking->booking_status !== 'CANCELED') {
            return back()->with('error', 'Chỉ có thể xóa booking đã hủy.');
        }

        $ownedBooking->delete();

        return back()->with('success', 'Đã xóa booking thành công.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        auth()->user()->update(
            $request->only('name', 'email', 'phone', 'address')
        );

        return back()->with('success', 'Cập nhật hồ sơ thành công');
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

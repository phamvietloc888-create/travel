<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentSetting;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CheckoutController extends Controller
{
    public function index(Request $request, Tour $tour)
    {
        $adult = (int) ($request->adult ?? 1);
        $child = (int) ($request->child ?? 0);
        $travelDate = $request->travel_date;

        return view('clients.checkout', [
            'tour' => $tour,
            'adult' => max(1, $adult),
            'child' => max(0, $child),
            'travel_date' => $travelDate,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'name' => 'required|string|min:2|max:255',
            'phone' => ['required', 'regex:/^(0|\+84)\d{9,10}$/'],
            'email' => 'required|email|max:255',
            'travel_date' => 'required|date|after_or_equal:today',
            'note' => 'nullable|string|max:1000',
        ]);

        $tour = Tour::findOrFail($request->tour_id);
        $adult = max(1, (int) $request->adult);
        $child = max(0, (int) $request->child);
        $requestedSeats = $adult + $child;

        if ($requestedSeats > $tour->remaining_seats) {
            return back()
                ->withErrors([
                    'adult' => 'So cho con lai khong du cho booking nay. Tour chi con '.$tour->remaining_seats.' cho.',
                ])
                ->withInput();
        }

        $total = ($adult * $tour->price_adult) + ($child * ($tour->price_child ?? 0));

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_id' => $tour->id,
            'booking_code' => 'BK'.strtoupper(uniqid()),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'customer_email' => $request->email,
            'travel_date' => $request->travel_date,
            'adult_qty' => $adult,
            'child_qty' => $child,
            'note' => $request->note,
            'total_amount' => $total,
            'booking_status' => 'PENDING',
            'payment_status' => 'UNPAID',
        ]);

        return redirect()
            ->route('booking.confirmation', $booking)
            ->with('success', 'Đặt tour thành công. Chúng tôi sẽ sớm xác nhận và gửi thông tin thanh toán cho bạn.');
    }

    public function confirmation(Booking $booking)
    {
        $booking = $this->ownedBookingQuery()
            ->with(['tour.destination', 'payment'])
            ->findOrFail($booking->id);

        return view('clients.booking-confirmation', compact('booking'));
    }

    public function payment(Booking $booking)
    {
        $booking = $this->ownedBookingQuery()
            ->with(['tour.destination', 'payment'])
            ->findOrFail($booking->id);

        abort_unless($booking->booking_status === 'CONFIRMED', 403);

        $simulationCode = 'PAY'.strtoupper(Str::random(6));
        session(['booking_payment_code_'.$booking->id => $simulationCode]);

        $paymentSettings = Schema::hasTable('payment_settings')
            ? PaymentSetting::query()->first()
            : null;

        return view('clients.payment', [
            'booking' => $booking,
            'paymentSettings' => $paymentSettings,
            'simulationCode' => $simulationCode,
        ]);
    }

    public function submitPayment(Request $request, Booking $booking)
    {
        $booking = $this->ownedBookingQuery()
            ->with('payment')
            ->findOrFail($booking->id);

        abort_unless($booking->booking_status === 'CONFIRMED', 403);

        $request->validate([
            'payment_method' => 'required|in:BANK_TRANSFER',
            'simulation_code' => 'required|string|max:20',
        ]);

        $expectedCode = session('booking_payment_code_'.$booking->id);
        if (!$expectedCode || strtoupper($request->simulation_code) !== strtoupper($expectedCode)) {
            return back()
                ->withErrors(['simulation_code' => 'Mã xác nhận thanh toán không đúng.'])
                ->withInput();
        }

        $bookingUpdate = [
            'payment_status' => 'PENDING',
        ];

        if (Booking::supportsCustomerNotifications()) {
            $bookingUpdate['customer_notice'] = 'Chúng tôi đã nhận thông tin thanh toán cho booking '.$booking->booking_code.'. Admin sẽ kiểm tra và xác nhận sớm.';
            $bookingUpdate['customer_notice_read_at'] = null;
        }

        $booking->update($bookingUpdate);

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'method' => 'BANK_TRANSFER',
                'amount' => $booking->total_amount,
                'status' => 'PENDING',
                'transaction_ref' => 'PAY-'.now()->format('YmdHis').'-'.$booking->id,
                'paid_at' => null,
            ]
        );

        session()->forget('booking_payment_code_'.$booking->id);

        return redirect()
            ->route('booking.confirmation', $booking)
            ->with('success', 'Đã gửi yêu cầu thanh toán. Admin sẽ kiểm tra giao dịch của bạn.');
    }

    protected function ownedBookingQuery()
    {
        $user = Auth::user();

        return Booking::query()
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

    public function paymentQr(): BinaryFileResponse
    {
        abort_unless(Schema::hasTable('payment_settings'), 404);

        $settings = PaymentSetting::query()->first();
        abort_if(!$settings || !$settings->qr_code_path, 404);

        $fullPath = storage_path('app/public/'.$settings->qr_code_path);
        abort_unless(is_file($fullPath), 404);

        return response()->file($fullPath);
    }
}

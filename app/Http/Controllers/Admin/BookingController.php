<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Models\Booking;
use App\Models\Tour;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService)
    {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'payment_status']);
        $bookings = $this->bookingService->paginate($filters);

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'filters' => $filters,
            'statuses' => Booking::STATUSES,
            'paymentStatuses' => Booking::PAYMENT_STATUSES,
        ]);
    }

    public function show(Booking $booking): View
    {
        $booking->load('tour.destination');

        return view('admin.bookings.show', [
            'booking' => $booking,
            'statuses' => Booking::STATUSES,
        ]);
    }

    public function edit(Booking $booking): View
    {
        $booking->load('tour.destination');

        return view('admin.bookings.edit', [
            'booking' => $booking,
            'tours' => Tour::orderBy('name')->get(),
            'statuses' => Booking::STATUSES,
            'paymentStatuses' => Booking::PAYMENT_STATUSES,
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $previousStatus = $booking->booking_status;
        $previousPaymentStatus = $booking->payment_status;

        $data = $request->validate([
            'tour_id' => ['required', 'exists:tours,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'customer_email' => ['required', 'string', 'email'],
            'adult_qty' => ['required', 'integer', 'min:0'],
            'child_qty' => ['required', 'integer', 'min:0'],
            'travel_date' => ['required', 'date'],
            'note' => ['nullable', 'string'],
            'admin_note' => ['nullable', 'string'],
            'booking_status' => ['required', 'in:PENDING,CONFIRMED,CANCELED,COMPLETED'],
            'payment_status' => ['required', 'in:UNPAID,PENDING,PAID,FAILED,REFUNDED'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ]);

        if (!Booking::supportsExtendedWorkflowFields()) {
            unset($data['admin_note']);
        }

        $booking->update($data);
        $this->syncCustomerNotice($booking, $previousStatus, $previousPaymentStatus);

        return redirect()->route('admin.bookings.index')->with('toast', 'Đã cập nhật booking.');
    }

    public function updateStatus(UpdateBookingStatusRequest $request, Booking $booking): RedirectResponse
    {
        $previousStatus = $booking->booking_status;
        $previousPaymentStatus = $booking->payment_status;
        $data = $request->validated();
        $booking->update([
            'booking_status' => $data['booking_status'],
            'payment_status' => $data['payment_status'] ?? $booking->payment_status,
        ]);
        $this->syncCustomerNotice($booking, $previousStatus, $previousPaymentStatus);

        return redirect()->route('admin.bookings.index')->with('toast', 'Trạng thái đã được cập nhật.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('toast', 'Đã xóa booking.');
    }

    protected function syncCustomerNotice(Booking $booking, string $previousStatus, string $previousPaymentStatus): void
    {
        if (!Booking::supportsCustomerNotifications()) {
            return;
        }

        $updates = [];
        $supportsExtendedWorkflowFields = Booking::supportsExtendedWorkflowFields();

        if ($previousStatus !== 'CONFIRMED' && $booking->booking_status === 'CONFIRMED') {
            if ($supportsExtendedWorkflowFields) {
                $updates['payment_ready_at'] = now();
            }
            $updates['customer_notice'] = 'Booking '.$booking->booking_code.' đã được admin xác nhận. Bạn có thể vào mục booking để tiến hành thanh toán.';
            $updates['customer_notice_read_at'] = null;
        }

        if ($previousStatus !== 'CANCELED' && $booking->booking_status === 'CANCELED') {
            $updates['customer_notice'] = 'Booking '.$booking->booking_code.' đã được cập nhật sang trạng thái đã hủy.';
            $updates['customer_notice_read_at'] = null;
        }

        if ($previousPaymentStatus !== 'PAID' && $booking->payment_status === 'PAID') {
            $updates['customer_notice'] = 'Thanh toán cho booking '.$booking->booking_code.' đã được admin xác nhận thành công.';
            $updates['customer_notice_read_at'] = null;
        }

        if (!empty($updates)) {
            $booking->forceFill($updates)->save();
        }
    }
}

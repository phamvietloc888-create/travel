<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookingService
{
    public function paginate(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Booking::query()->with('tour.destination');

        if (!empty($filters['status'])) {
            $query->where('booking_status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('customer_name', 'like', "%{$filters['search']}%")
                    ->orWhere('customer_email', 'like', "%{$filters['search']}%")
                    ->orWhere('customer_phone', 'like', "%{$filters['search']}%")
                    ->orWhere('booking_code', 'like', "%{$filters['search']}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

}

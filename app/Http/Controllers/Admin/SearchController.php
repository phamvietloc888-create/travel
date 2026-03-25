<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));

        $tours = collect();
        $destinations = collect();
        $bookings = collect();

        if ($query !== '') {
            $likeQuery = '%'.$query.'%';

            $tours = Tour::query()
                ->with('destination')
                ->where(function ($builder) use ($likeQuery) {
                    $builder->where('name', 'like', $likeQuery)
                        ->orWhere('slug', 'like', $likeQuery)
                        ->orWhere('start_location', 'like', $likeQuery);
                })
                ->latest()
                ->limit(8)
                ->get();

            $destinations = Destination::query()
                ->where(function ($builder) use ($likeQuery) {
                    $builder->where('name', 'like', $likeQuery)
                        ->orWhere('province', 'like', $likeQuery)
                        ->orWhere('region', 'like', $likeQuery)
                        ->orWhere('slug', 'like', $likeQuery);
                })
                ->latest()
                ->limit(8)
                ->get();

            $bookings = Booking::query()
                ->with('tour')
                ->where(function ($builder) use ($likeQuery) {
                    $builder->where('booking_code', 'like', $likeQuery)
                        ->orWhere('customer_name', 'like', $likeQuery)
                        ->orWhere('customer_email', 'like', $likeQuery)
                        ->orWhere('customer_phone', 'like', $likeQuery);
                })
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('admin.search.index', [
            'query' => $query,
            'tours' => $tours,
            'destinations' => $destinations,
            'bookings' => $bookings,
            'resultCount' => $tours->count() + $destinations->count() + $bookings->count(),
            'queryPreview' => Str::limit($query, 60),
        ]);
    }
}

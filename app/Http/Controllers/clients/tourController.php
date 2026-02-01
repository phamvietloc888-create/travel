<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Destination;

class TourController extends Controller
{
    /**
     * Trang danh sách TẤT CẢ tour
     * URL: /tours
     */
    public function index()
    {
        $tours = Tour::with('destination')
            ->where('status', 'PUBLISHED')
            ->latest()
            ->paginate(9);

        return view('clients.tour', compact('tours'));
    }

    /**
     * Trang tour THEO ĐIỂM ĐẾN
     * URL: /tours/destination/{slug}
     */
    public function byDestination($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('status', 'PUBLISHED')
            ->firstOrFail();

        $tours = Tour::with('destination')
            ->where('destination_id', $destination->id)
            ->where('status', 'PUBLISHED')
            ->latest()
            ->paginate(9);

        return view('clients.tour', compact('tours', 'destination'));
    }
}

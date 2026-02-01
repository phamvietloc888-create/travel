<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Initialize stats with default values
        $stats = [
            'destinations' => 0,
            'tours' => 0,
            'bookings' => 0,
            'reviews' => 0,
        ];

        // Try to fetch stats safely
        try {
            $stats['destinations'] = Destination::count();
        } catch (\Exception $e) {
            // Table or model might not exist
        }

        try {
            $stats['tours'] = Tour::count();
        } catch (\Exception $e) {
            // Table or model might not exist
        }

        try {
            $stats['bookings'] = Booking::count();
        } catch (\Exception $e) {
            // Table or model might not exist
        }

        try {
            $stats['reviews'] = Review::count();
        } catch (\Exception $e) {
            // Table or model might not exist
        }

        $recentBookings = [];
        try {
            $recentBookings = Booking::with('tour.destination')->latest()->take(5)->get();
        } catch (\Exception $e) {
            // Table might not exist
        }

        $bookingsByMonth = [];
        $chart = [
            'labels' => [],
            'values' => [],
        ];

        try {
            $bookingsByMonth = Booking::select(DB::raw("DATE_FORMAT(travel_date, '%Y-%m') as month"), DB::raw('count(*) as total'))
                ->groupBy('month')
                ->orderBy('month')
                ->limit(12)
                ->get();

            $chart = [
                'labels' => $bookingsByMonth->pluck('month'),
                'values' => $bookingsByMonth->pluck('total'),
            ];
        } catch (\Exception $e) {
            // Query might fail
        }

        $topTours = [];
        try {
            $topTours = Tour::select('id', 'name', 'thumbnail_path')
                ->withCount('bookings')
                ->orderByDesc('bookings_count')
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            // Query might fail
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'chart' => $chart,
            'topTours' => $topTours,
        ]);
    }
}

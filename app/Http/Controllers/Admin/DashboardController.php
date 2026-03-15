<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Review;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'destinations' => 0,
            'tours' => 0,
            'bookings' => 0,
            'reviews' => 0,
        ];

        try {
            $stats['destinations'] = Destination::count();
        } catch (\Exception $e) {
        }

        try {
            $stats['tours'] = Tour::count();
        } catch (\Exception $e) {
        }

        try {
            $stats['bookings'] = Booking::count();
        } catch (\Exception $e) {
        }

        try {
            $stats['reviews'] = Review::count();
        } catch (\Exception $e) {
        }

        $recentBookings = collect();
        try {
            $recentBookings = Booking::with('tour.destination')->latest()->take(5)->get();
        } catch (\Exception $e) {
        }

        $chart = [
            'labels' => [],
            'values' => [],
            'revenues' => [],
        ];

        try {
            $monthly = Booking::query()
                ->selectRaw("DATE_FORMAT(travel_date, '%Y-%m') as month")
                ->selectRaw('COUNT(*) as total_bookings')
                ->selectRaw('COALESCE(SUM(total_amount), 0) as total_revenue')
                ->groupBy('month')
                ->orderByDesc('month')
                ->limit(12)
                ->get()
                ->sortBy('month')
                ->values();

            $chart = [
                'labels' => $monthly->map(function ($row) {
                    return Carbon::createFromFormat('Y-m', $row->month)->format('m/Y');
                })->values(),
                'values' => $monthly->pluck('total_bookings')->values(),
                'revenues' => $monthly->pluck('total_revenue')->map(fn ($value) => (float) $value)->values(),
            ];
        } catch (\Exception $e) {
        }

        $topTours = collect();
        try {
            $topTours = Tour::select('id', 'name', 'thumbnail_path')
                ->withCount('bookings')
                ->orderByDesc('bookings_count')
                ->take(4)
                ->get();
        } catch (\Exception $e) {
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'chart' => $chart,
            'topTours' => $topTours,
        ]);
    }
}

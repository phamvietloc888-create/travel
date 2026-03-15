<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Support\ImagePathResolver;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 3 tour mới nhất
        $reviewStats = DB::table('reviews')
            ->select(
                'tour_id',
                DB::raw('COUNT(*) as total_reviews'),
                DB::raw('AVG(rating) as avg_rating')
            )
            ->where('status', 'APPROVED')
            ->groupBy('tour_id');

        $tourDestinations = DB::table('tours as t')
            ->join('destinations as d', 'd.id', '=', 't.destination_id')
            ->leftJoinSub($reviewStats, 'review_stats', function ($join) {
                $join->on('review_stats.tour_id', '=', 't.id');
            })
            ->where('t.status', 'PUBLISHED')
            ->select(
                't.id',
                't.name as tour_name',
                't.slug',
                't.price_adult',
                't.duration_days',
                't.thumbnail_path',
                'd.name as destination_name',
                'd.province',
                DB::raw('COALESCE(review_stats.total_reviews, 0) as total_reviews'),
                DB::raw('COALESCE(review_stats.avg_rating, 0) as avg_rating')
            )
            ->orderByDesc('t.created_at')
            ->limit(3)
            ->get()
            ->map(function ($tour) {
                $tour->thumbnail_url = ImagePathResolver::tourUrl(
                    $tour->thumbnail_path,
                    $tour->slug,
                    $tour->tour_name
                );

                return $tour;
            });

        // Destination nhiều tour nhất
        $carouselDestinations = DB::table('destinations as d')
            ->leftJoin('tours as t', function ($join) {
                $join->on('t.destination_id', '=', 'd.id')
                     ->where('t.status', 'PUBLISHED');
            })
            ->where('d.status', 'PUBLISHED')
            ->groupBy('d.id', 'd.name', 'd.slug', 'd.thumbnail_path')
            ->select(
                'd.id',
                'd.name',
                'd.slug',
                'd.thumbnail_path',
                DB::raw('COUNT(t.id) as total_tours')
            )
            ->orderByDesc('total_tours')
            ->get()
            ->map(function ($destination) {
                $destination->thumbnail_url = ImagePathResolver::destinationUrl(
                    $destination->thumbnail_path,
                    $destination->slug,
                    $destination->name
                );

                return $destination;
            });

        return view('clients.home', compact(
            'tourDestinations',
            'carouselDestinations'
        ));
    }
}

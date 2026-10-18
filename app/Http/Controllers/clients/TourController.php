<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::with('destination')
            ->withCount(['reviews as total_reviews' => function ($q) {
                $q->where('status', 'APPROVED');
            }])
            ->withAvg(['reviews as avg_rating' => function ($q) {
                $q->where('status', 'APPROVED');
            }], 'rating')
            ->where('status', 'PUBLISHED');

        $keywordInput = trim((string) ($request->keyword ?: $request->destination));

        if ($keywordInput !== '') {
            $keyword = str_replace('-', '', Str::slug($keywordInput));

            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->whereRaw(
                    "LOWER(REPLACE(REPLACE(REPLACE(name,'đ','d'),'Đ','D'),' ','')) LIKE ?",
                    ['%' . $keyword . '%']
                )->orWhereHas('destination', function ($destinationQuery) use ($keyword) {
                    $destinationQuery->whereRaw(
                        "LOWER(REPLACE(REPLACE(REPLACE(name,'đ','d'),'Đ','D'),' ','')) LIKE ?",
                        ['%' . $keyword . '%']
                    );
                });
            });
        }

        if ($request->filled('start_location')) {
            $keyword = str_replace('-', '', Str::slug($request->start_location));

            $query->whereRaw(
                "LOWER(REPLACE(REPLACE(REPLACE(start_location,'đ','d'),'Đ','D'),' ','')) LIKE ?",
                ['%' . $keyword . '%']
            );
        }

        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        if ($request->filled('budget')) {
            switch ($request->budget) {
                case 'duoi-5':
                    $query->where('price_adult', '<', 5000000);
                    break;
                case '5-10':
                    $query->whereBetween('price_adult', [5000000, 10000000]);
                    break;
                case '10-20':
                    $query->whereBetween('price_adult', [10000000, 20000000]);
                    break;
                case 'tren-20':
                    $query->where('price_adult', '>', 20000000);
                    break;
            }
        }

        if ($request->filled('start_date')) {
            Carbon::parse($request->start_date);
        }

        $tours = $query->latest()
            ->paginate(9)
            ->withQueryString();

        $destinations = Destination::where('status', 'PUBLISHED')->get();

        $startLocations = Tour::where('status', 'PUBLISHED')
            ->whereNotNull('start_location')
            ->select('start_location')
            ->distinct()
            ->pluck('start_location');

        return view('clients.tour', compact(
            'tours',
            'destinations',
            'startLocations'
        ));
    }

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

        $destinations = Destination::where('status', 'PUBLISHED')->get();

        $startLocations = Tour::where('status', 'PUBLISHED')
            ->whereNotNull('start_location')
            ->select('start_location')
            ->distinct()
            ->pluck('start_location');

        return view('clients.tour', compact(
            'tours',
            'destination',
            'destinations',
            'startLocations'
        ));
    }

    public function show($slug)
    {
        $tour = Tour::with([
                'destination',
                'reviews.user',
            ])
            ->where('slug', $slug)
            ->where('status', 'PUBLISHED')
            ->firstOrFail();

        $relatedTours = Tour::with('destination')
            ->where('destination_id', $tour->destination_id)
            ->where('id', '!=', $tour->id)
            ->where('status', 'PUBLISHED')
            ->latest()
            ->limit(3)
            ->get();

        return view('clients.tour-detail', compact(
            'tour',
            'relatedTours'
        ));
    }
}

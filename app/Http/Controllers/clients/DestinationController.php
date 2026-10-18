<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Danh sach destination
     */
    public function index(Request $request)
    {
        $regions = ['Miền Bắc', 'Miền Trung', 'Miền Nam'];
        $currentRegion = $request->query('region');

        $query = Destination::withCount('tours')
            ->where('status', 'PUBLISHED')
            ->latest();

        if (in_array($currentRegion, $regions, true)) {
            $query->where('region', $currentRegion);
        } else {
            $currentRegion = null;
        }

        $destinations = $query->paginate(6)->withQueryString();

        return view('clients.destination', compact('destinations', 'regions', 'currentRegion'));
    }

    /**
     * Danh sach tour theo destination
     */
    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('status', 'PUBLISHED')
            ->firstOrFail();

        $tours = Tour::where('destination_id', $destination->id)
            ->where('status', 'PUBLISHED')
            ->latest()
            ->paginate(6);

        return view('clients.tours-by-destination', compact('destination', 'tours'));
    }
}

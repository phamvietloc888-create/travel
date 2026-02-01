<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Danh sách destination
     */
    public function index()
    {
        $destinations = Destination::withCount('tours')
            ->where('status', 'PUBLISHED')
            ->latest()
            ->paginate(6);

        return view('clients.destination', compact('destinations'));
    }

    /**
     * Danh sách tour theo destination
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

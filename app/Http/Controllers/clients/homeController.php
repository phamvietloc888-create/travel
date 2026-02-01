<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
    public function index()
    {
        $tourDestinations = DB::table('tours as t')
            ->join('destinations as d', 'd.id', '=', 't.destination_id')
            ->where('t.status', 'PUBLISHED')
            ->select(
                't.id',
                't.name as tour_name',
                't.slug',
                't.price_adult',
                't.duration_days',
                't.thumbnail_path',
                'd.name as destination_name',
                'd.province'
            )
            ->latest('t.created_at')
            ->limit(3)
            ->get();

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
            ->get();

        return view('clients.home', compact(
            'tourDestinations',
            'carouselDestinations'
        ));
    }
}


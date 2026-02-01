<?php

namespace App\Services;

use App\Models\Tour;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TourService
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Tour::query()->with('destination');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('start_location', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['destination_id'])) {
            $query->where('destination_id', $filters['destination_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function store(array $data): Tour
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $tour = Tour::create($data);
        return $tour;
    }

    public function update(Tour $tour, array $data): Tour
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $tour->update($data);
        return $tour;
    }

    public function delete(Tour $tour): void
    {
        $tour->delete();
    }
}

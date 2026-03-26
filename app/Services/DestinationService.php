<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class DestinationService
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Destination::query()->withCount('tours');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('province', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function listAll(): Collection
    {
        return Destination::orderBy('name')->get();
    }

    public function store(array $data): Destination
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return Destination::create($data);
    }

    public function update(Destination $destination, array $data): Destination
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $destination->update($data);

        return $destination;
    }

    public function delete(Destination $destination): void
    {
        $destination->delete();
    }
}

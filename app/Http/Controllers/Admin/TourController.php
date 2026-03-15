<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourImage;
use App\Services\DestinationService;
use App\Services\MediaService;
use App\Services\TourService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TourController extends Controller
{
    public function __construct(
        protected TourService $tourService,
        protected DestinationService $destinationService,
        protected MediaService $mediaService,
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'destination_id']);
        $tours = $this->tourService->paginate($filters);

        return view('admin.tours.index', [
            'tours' => $tours,
            'destinations' => $this->destinationService->listAll(),
            'filters' => $filters,
            'statuses' => Tour::STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('admin.tours.create', [
            'destinations' => $this->destinationService->listAll(),
            'statuses' => Tour::STATUSES,
        ]);
    }

    public function store(StoreTourRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $media = $this->mediaService->upload($request->file('thumbnail'), 'tours', $request->user()?->id);
            $data['thumbnail_path'] = $media?->path;
        }

        $tour = $this->tourService->store($data);
        $this->syncImagesAndSchedules($tour, $request);

        return redirect()->route('admin.tours.index')->with('toast', 'Tạo tour thành công.');
    }

    public function edit(Tour $tour): View
    {
        return view('admin.tours.edit', [
            'tour' => $tour,
            'destinations' => $this->destinationService->listAll(),
            'statuses' => Tour::STATUSES,
        ]);
    }

    public function update(UpdateTourRequest $request, Tour $tour): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $media = $this->mediaService->upload($request->file('thumbnail'), 'tours', $request->user()?->id);
            $data['thumbnail_path'] = $media?->path;
        }

        $tour = $this->tourService->update($tour, $data);
        $this->syncImagesAndSchedules($tour, $request, true);

        return redirect()->route('admin.tours.index')->with('toast', 'Cập nhật tour thành công.');
    }

    public function destroy(Tour $tour): RedirectResponse
    {
        $this->tourService->delete($tour);
        return redirect()->route('admin.tours.index')->with('toast', 'Đã xóa tour.');
    }

    public function destroyImage(Tour $tour, TourImage $image): RedirectResponse
    {
        abort_if($image->tour_id !== $tour->id, 404);

        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('toast', 'Đã xóa ảnh khỏi gallery.');
    }

    protected function syncImagesAndSchedules(Tour $tour, Request $request, bool $clear = false): void
    {
        if ($clear) {
            $tour->schedules()->delete();
        }

        if ($request->hasFile('images')) {
            $remainingSlots = max(0, 3 - $tour->images()->count());
            if ($remainingSlots === 0) {
                return;
            }

            $startOrder = (int) $tour->images()->max('sort_order') + 1;
            foreach (array_slice($request->file('images'), 0, $remainingSlots) as $index => $file) {
                if (!$file) {
                    continue;
                }
                $uploaded = $this->mediaService->upload($file, 'tours/gallery', $request->user()?->id);
                if ($uploaded) {
                    $tour->images()->create([
                        'image_path' => $uploaded->path,
                        'sort_order' => $startOrder + $index,
                    ]);
                }
            }
        }

        $schedules = $request->input('schedules', []);
        foreach ($schedules as $schedule) {
            if (empty($schedule['day_no']) && empty($schedule['title'])) {
                continue;
            }
            $tour->schedules()->create([
                'day_no' => $schedule['day_no'] ?? 1,
                'title' => $schedule['title'] ?? '',
                'detail' => $schedule['detail'] ?? '',
            ]);
        }
    }
}

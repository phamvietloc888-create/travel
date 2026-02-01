<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;
use App\Models\Destination;
use App\Services\DestinationService;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function __construct(
        protected DestinationService $destinationService,
        protected MediaService $mediaService,
    ) {
    }

    public function index(Request $request): View
    {
        $destinations = $this->destinationService->paginate($request->only(['search', 'status']));

        return view('admin.destinations.index', [
            'destinations' => $destinations,
            'filters' => $request->only(['search', 'status']),
            'statuses' => Destination::STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('admin.destinations.create', [
            'statuses' => Destination::STATUSES,
        ]);
    }

    public function store(StoreDestinationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $media = $this->mediaService->upload($request->file('thumbnail'), 'destinations', $request->user()?->id);
            $data['thumbnail_path'] = $media?->path;
        }

        $this->destinationService->store($data);

        return redirect()->route('admin.destinations.index')->with('toast', 'Tạo điểm đến thành công.');
    }

    public function edit(Destination $destination): View
    {
        return view('admin.destinations.edit', [
            'destination' => $destination,
            'statuses' => Destination::STATUSES,
        ]);
    }

    public function update(UpdateDestinationRequest $request, Destination $destination): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $media = $this->mediaService->upload($request->file('thumbnail'), 'destinations', $request->user()?->id);
            $data['thumbnail_path'] = $media?->path;
        }

        $this->destinationService->update($destination, $data);

        return redirect()->route('admin.destinations.index')->with('toast', 'Cập nhật điểm đến thành công.');
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        $this->destinationService->delete($destination);
        return redirect()->route('admin.destinations.index')->with('toast', 'Đã xóa điểm đến.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateReviewStatusRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $reviews = Review::with(['user', 'tour'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'statuses' => Review::STATUSES,
            'filters' => ['status' => $status],
        ]);
    }

    public function updateStatus(UpdateReviewStatusRequest $request, Review $review): RedirectResponse
    {
        $review->update(['status' => $request->validated()['status']]);
        return redirect()->route('admin.reviews.index')->with('toast', 'Đã cập nhật trạng thái review.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('toast', 'Đã xóa review.');
    }
}

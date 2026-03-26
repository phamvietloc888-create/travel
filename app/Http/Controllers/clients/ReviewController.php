<?php


namespace App\Http\Controllers\Clients;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'tour_id' => $request->tour_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => Review::STATUSES[1], // Mặc định là PENDING
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!.');
    }
}               
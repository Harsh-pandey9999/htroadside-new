<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $rating = $request->get('rating', 'all');
        
        $query = Review::where('user_id', $user->id);
        
        if ($rating !== 'all') {
            $query->where('rating', $rating);
        }
        
        $reviews = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        // Calculate statistics
        $stats = [
            'average_rating' => $user->rating,
            'total_reviews' => Review::where('user_id', $user->id)->count(),
            'rating_distribution' => [
                5 => Review::where('user_id', $user->id)->where('rating', 5)->count(),
                4 => Review::where('user_id', $user->id)->where('rating', 4)->count(),
                3 => Review::where('user_id', $user->id)->where('rating', 3)->count(),
                2 => Review::where('user_id', $user->id)->where('rating', 2)->count(),
                1 => Review::where('user_id', $user->id)->where('rating', 1)->count(),
            ]
        ];
        
        return view('provider.reviews.index', compact('reviews', 'rating', 'stats'));
    }
}

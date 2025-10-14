<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewRepositoryInterface $repository,
        private ReviewService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'reviewee_id' => 'nullable|integer|exists:users,id',
            'reviewer_id' => 'nullable|integer|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Review::query()->with(['reviewer', 'reviewee', 'greeting']);

        // Filter by reviewee (person being reviewed)
        if ($request->reviewee_id) {
            $query->where('reviewee_id', $request->reviewee_id);
        }

        // Filter by reviewer (person who wrote the review)
        if ($request->reviewer_id) {
            $query->where('reviewer_id', $request->reviewer_id);
        }

        // Filter by rating
        if ($request->rating) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'reviews' => $reviews->items(),
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'total_pages' => $reviews->lastPage(),
                'total_items' => $reviews->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reviewee_id' => 'required|integer|exists:users,id|different:' . Auth::id(),
            'greeting_id' => 'nullable|integer|exists:greetings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        $reviewerId = Auth::id();
        $revieweeId = $request->reviewee_id;

        // Check if reviewee is a creator
        $reviewee = User::find($revieweeId);
        if (!$reviewee->is_creator) {
            return response()->json([
                'message' => 'Reviews can only be written for creators'
            ], 400);
        }

        // Check if reviewer has already reviewed this creator
        $existingReview = Review::where('reviewer_id', $reviewerId)
            ->where('reviewee_id', $revieweeId)
            ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'You have already reviewed this creator'
            ], 409);
        }

        try {
            $review = $this->service->createReview($reviewerId, $request->validated());
            
            return response()->json([
                'message' => 'Review created successfully',
                'review' => $review->load(['reviewer', 'reviewee', 'greeting'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json([
            'review' => $review->load(['reviewer', 'reviewee', 'greeting'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Only the reviewer can update their own review
        if (Auth::id() !== $review->reviewer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'sometimes|nullable|string|max:1000',
            'is_anonymous' => 'sometimes|boolean',
        ]);

        try {
            $updated = $this->service->updateReview($review, $request->validated());
            
            if ($updated) {
                return response()->json([
                    'message' => 'Review updated successfully',
                    'review' => $review->fresh()->load(['reviewer', 'reviewee', 'greeting'])
                ]);
            }

            return response()->json([
                'message' => 'Failed to update review'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Only the reviewer can delete their own review
        if (Auth::id() !== $review->reviewer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $deleted = $this->repository->deleteReview($review->id);
            
            if ($deleted) {
                // Update creator's rating after review deletion
                $this->service->updateCreatorRating($review->reviewee_id);
                
                return response()->json([
                    'message' => 'Review deleted successfully'
                ]);
            }

            return response()->json([
                'message' => 'Failed to delete review'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reviews for a specific user (creator)
     */
    public function userReviews(User $user)
    {
        // Only show reviews for creators
        if (!$user->is_creator) {
            return response()->json([
                'message' => 'User is not a creator'
            ], 400);
        }

        $reviews = Review::where('reviewee_id', $user->id)
            ->with(['reviewer', 'greeting'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = $this->service->getReviewStats($user->id);

        return response()->json([
            'user' => $user->load('creatorProfile'),
            'reviews' => $reviews->items(),
            'stats' => $stats,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'total_pages' => $reviews->lastPage(),
                'total_items' => $reviews->total(),
            ]
        ]);
    }

    /**
     * Get review statistics for a creator
     */
    public function stats(User $user)
    {
        if (!$user->is_creator) {
            return response()->json([
                'message' => 'User is not a creator'
            ], 400);
        }

        try {
            $stats = $this->service->getReviewStats($user->id);
            
            return response()->json([
                'user_id' => $user->id,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get review statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get top-rated creators
     */
    public function topRated(Request $request)
    {
        $request->validate([
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        try {
            $topCreators = $this->service->getTopRatedCreators($request->limit ?? 10);
            
            return response()->json([
                'top_creators' => $topCreators
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get top-rated creators',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

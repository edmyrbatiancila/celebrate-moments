<?php

namespace App\Services;

use App\Models\Review;
use App\Models\User;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ReviewService
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
        private CreatorProfileService $creatorProfileService
    ) {}

    public function createReview(int $reviewerId, array $data): Review
    {
        $data['reviewer_id'] = $reviewerId;
        
        $review = $this->reviewRepository->createReview($data);
        
        // Update creator's overall rating
        $this->updateCreatorRating($review->reviewee_id);
        
        return $review;
    }

    public function updateReview(Review $review, array $data): bool
    {
        $updated = $review->update($data);
        
        if ($updated) {
            // Update creator's overall rating after review update
            $this->updateCreatorRating($review->reviewee_id);
        }
        
        return $updated;
    }

    public function updateCreatorRating(int $creatorId): void
    {
        $user = User::find($creatorId);
        if ($user && $user->is_creator && $user->creatorProfile) {
            $this->creatorProfileService->updateRating($user->creatorProfile);
        }
    }

    public function getReviewStats(int $creatorId): array
    {
        $reviews = Review::where('reviewee_id', $creatorId)->get();
        
        if ($reviews->isEmpty()) {
            return [
                'total_reviews' => 0,
                'average_rating' => 0,
                'rating_distribution' => [
                    '5' => 0, '4' => 0, '3' => 0, '2' => 0, '1' => 0
                ]
            ];
        }

        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[(string)$i] = $reviews->where('rating', $i)->count();
        }

        return [
            'total_reviews' => $reviews->count(),
            'average_rating' => round($reviews->avg('rating'), 2),
            'rating_distribution' => $ratingDistribution,
            'recent_reviews' => $reviews->sortByDesc('created_at')->take(5)->values()
        ];
    }

    public function getTopRatedCreators(int $limit = 10): Collection
    {
        return User::where('is_creator', true)
            ->where('is_verified_creator', true)
            ->with(['creatorProfile'])
            ->whereHas('creatorProfile', function ($query) {
                $query->where('rating', '>', 0);
            })
            ->get()
            ->sortByDesc(function ($user) {
                return $user->creatorProfile->rating ?? 0;
            })
            ->take($limit)
            ->values();
    }

    public function canUserReview(int $reviewerId, int $revieweeId): bool
    {
        // Check if reviewer has already reviewed this creator
        $existingReview = Review::where('reviewer_id', $reviewerId)
            ->where('reviewee_id', $revieweeId)
            ->exists();

        return !$existingReview;
    }

    public function getCreatorReviews(int $creatorId, int $limit = null): Collection
    {
        $query = Review::where('reviewee_id', $creatorId)
            ->with(['reviewer', 'greeting'])
            ->orderBy('created_at', 'desc');

        if ($limit) {
            return $query->take($limit)->get();
        }

        return $query->get();
    }

    public function deleteReview(Review $review): bool
    {
        $deleted = $this->reviewRepository->deleteReview($review->id);
        
        if ($deleted) {
            // Update creator's rating after deletion
            $this->updateCreatorRating($review->reviewee_id);
        }
        
        return $deleted;
    }
}
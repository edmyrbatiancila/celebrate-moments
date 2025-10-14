<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getAllReviews(): Collection
    {
        return Review::with(['reviewer', 'reviewee', 'greeting'])->get();
    }

    public function getReviewById(int $id): ?Review
    {
        try {
            return Review::with(['reviewer', 'reviewee', 'greeting'])->find($id);
        } catch (\Exception $e) {
            Log::error("Error finding Review by ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function createReview(array $data): Review
    {
        return Review::create($data);
    }

    public function updateReview(int $id, array $data): bool
    {
        try {
            $review = Review::findOrFail($id);
            return $review->update($data);
        } catch (\Exception $e) {
            Log::error("Error updating Review ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function deleteReview(int $id): bool
    {
        try {
            $review = Review::findOrFail($id);
            return $review->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting Review ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    // Additional specific methods
    public function getReviewsByReviewee(int $revieweeId): Collection
    {
        return Review::with(['reviewer', 'greeting'])
            ->where('reviewee_id', $revieweeId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getReviewsByReviewer(int $reviewerId): Collection
    {
        return Review::with(['reviewee', 'greeting'])
            ->where('reviewer_id', $reviewerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAverageRating(int $revieweeId): float
    {
        return Review::where('reviewee_id', $revieweeId)
            ->avg('rating') ?? 0.0;
    }

    public function getRecentReviews(int $limit = 10): Collection
    {
        return Review::with(['reviewer', 'reviewee', 'greeting'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
<?php

namespace App\Repositories\Interfaces;

use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface
{
    public function getAllReviews(): Collection;

    public function getReviewById(int $id): ?Review;

    public function createReview(array $data): Review;

    public function updateReview(int $id, array $data): bool;

    public function deleteReview(int $id): bool;
}

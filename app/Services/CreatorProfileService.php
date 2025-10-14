<?php

namespace App\Services;

use App\Models\CreatorProfile;
use App\Repositories\Interfaces\CreatorProfileRepositoryInterface;

class CreatorProfileService
{
    public function __construct(
        private CreatorProfileRepositoryInterface $repository
    ) {}

    public function createProfile(int $userId, array $data): CreatorProfile
    {
        $data['user_id'] = $userId;

        return $this->repository->create($data);
    }

    public function updateProfile(CreatorProfile $profile, array $data): bool
    {
        // Update rating if reviews exist
        if ($profile->reviews()->count() > 0) {
            $data['rating'] = $profile->getAverageRating();
        }
        
        return $this->repository->update($profile, $data);
    }

    public function verifyCreator(CreatorProfile $profile): bool
    {
        return $this->repository->update($profile, [
            'verification_status' => 'approved'
        ]);
    }

    public function rejectCreator(CreatorProfile $profile, string $reason = null): bool
    {
        return $this->repository->update($profile, [
            'verification_status' => 'rejected'
        ]);
    }

    public function getCreatorStats(CreatorProfile $profile): array
    {
        return [
            'total_greetings' => $profile->greetings()->count(),
            'total_templates' => $profile->templates()->count(),
            'average_rating' => $profile->rating,
            'total_reviews' => $profile->reviews()->count(),
            'earnings_this_month' => $this->calculateMonthlyEarnings($profile),
        ];
    }

    private function calculateMonthlyEarnings(CreatorProfile $profile): float
    {
        // Calculate earnings from greetings created this month
        return $profile->greetings()
            ->where('created_at', '>=', now()->startOfMonth())
            ->where('status', 'delivered')
            ->sum('price') ?? 0;
    }

    public function updateRating(CreatorProfile $profile): void
    {
        $averageRating = $profile->reviews()->avg('rating');
        $profile->update(['rating' => round($averageRating, 2)]);
    }
}
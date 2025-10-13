<?php

namespace App\Repositories;

use App\Models\CreatorProfile;
use App\Repositories\Interfaces\CreatorProfileRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CreatorProfileRepository implements CreatorProfileRepositoryInterface
{
    public function getAllCreators(): Collection
    {
        return CreatorProfile::with('user')->where('availability_status', true)->get();
    }

    public function getVerifiedCreators(): Collection
    {
        return CreatorProfile::with('user')
            ->where('verification_status', 'approved')
            ->where('availability_status', true)
            ->get();
    }

    public function findByUserId(int $userId): ?CreatorProfile
    {
        return CreatorProfile::where('user_id', $userId)->first();
    }

    public function create(array $data): CreatorProfile
    {
        return CreatorProfile::create($data);
    }

    public function update(CreatorProfile $profile, array $data): bool
    {
        return $profile->update($data);
    }
    
    public function delete(CreatorProfile $profile): bool
    {
        return $profile->delete();
    }
}
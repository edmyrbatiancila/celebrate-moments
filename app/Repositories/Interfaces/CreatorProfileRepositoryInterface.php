<?php

namespace App\Repositories\Interfaces;

use App\Models\CreatorProfile;
use Illuminate\Database\Eloquent\Collection;

interface CreatorProfileRepositoryInterface
{
    public function getAllCreators(): Collection;
    public function getVerifiedCreators(): Collection;
    public function findByUserId(int $userId): ?CreatorProfile;
    public function create(array $data): CreatorProfile;
    public function update(CreatorProfile $profile, array $data): bool;
    public function delete(CreatorProfile $profile): bool;
}

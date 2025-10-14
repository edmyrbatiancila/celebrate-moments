<?php

namespace App\Repositories\Interfaces;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;

interface MediaRepositoryInterface
{
    public function getAllMedia(): Collection;

    public function getMediaById(int $id): ?Media;

    public function createMedia(array $data): Media;

    public function updateMedia(int $id, array $data): bool;

    public function deleteMedia(int $id): bool;

    public function getMediaByType(string $type): Collection;

    public function getMediaByUser(int $userId): Collection;

    public function getMediaByGreeting(int $greetingId): Collection;
}

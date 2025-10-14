<?php


namespace App\Repositories;

use App\Models\Media;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class MediaRepository implements MediaRepositoryInterface
{
    public function getAllMedia(): Collection
    {
        return Media::with(['user', 'greeting'])->get();
    }

    public function getMediaById(int $id): ?Media
    {
        try {
            return Media::with(['user', 'greetings'])->find($id);
        } catch (\Exception $e) {
            Log::error("Error finding Media by ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function createMedia(array $data): Media
    {
        return Media::create($data);
    }

    public function updateMedia(int $id, array $data): bool
    {
        try {
            $media = Media::findOrFail($id);
            return $media->update($data);
        } catch (\Exception $e) {
            Log::error("Error updating Media ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function deleteMedia(int $id): bool
    {
        try {
            $media = Media::findOrFail($id);
            return $media->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting Media ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    // Additional specific methods
    public function getMediaByType(string $type): Collection
    {
        return Media::with(['user', 'greetings'])
            ->where('media_type', $type)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMediaByUser(int $userId): Collection
    {
        return Media::with(['greetings'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMediaByGreeting(int $greetingId): Collection
    {
        return Media::with(['user'])
            ->whereHas('greetings', function ($query) use ($greetingId) {
                $query->where('greeting_id', $greetingId);
            })
            ->orderBy('order', 'asc')
            ->get();
    }
}
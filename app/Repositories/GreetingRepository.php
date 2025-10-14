<?php

namespace App\Repositories;

use App\Models\Greeting;
use App\Repositories\Interfaces\GreetingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class GreetingRepository implements GreetingRepositoryInterface
{
    public function getAllGreetings(): Collection
    {
        return Greeting::with(['creator', 'recipients', 'media', 'analytics'])->get();
    }

    public function getGreetingsByCreator(int $creatorId): Collection
    {
        return Greeting::with(['recipients', 'media', 'analytics'])
            ->where('creator_id', $creatorId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getGreetingsByRecipient(int $recipientId): Collection
    {
        // Get greetings where user is a recipient (many-to-many relationship)
        return Greeting::with(['creator', 'media', 'analytics'])
            ->whereHas('recipients', function ($query) use ($recipientId) {
                $query->where('recipient_id', $recipientId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getGreetingsByStatus(string $status): Collection
    {
        return Greeting::with(['creator', 'recipients', 'media', 'analytics'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById(int $id): ?Greeting
    {
        try {
            return Greeting::with(['creator', 'recipients', 'media', 'analytics'])
                ->find($id);
        } catch (\Exception $e) {
            // Log error if needed
            Log::error("Error finding Greeting by ID {$id}: " . $e->getMessage());
            
            return null;
        }
    }

    public function create(array $data): Greeting
    {
        return Greeting::create($data);
    }

    public function update(Greeting $greeting, array $data): bool
    {
        return $greeting->update($data);
    }

    public function delete(Greeting $greeting): bool
    {
        return $greeting->delete();
    }

    public function getScheduledGreetings(): Collection
    {
        return Greeting::with(['creator', 'recipients', 'media', 'analytics'])
            ->where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function markAsDelivered(Greeting $greeting): bool
    {
        return $greeting->update(['status' => 'delivered']);
    }

    // ... implement all other interface methods
}
<?php

namespace App\Services;

use App\Models\Greeting;
use App\Repositories\Interfaces\GreetingRepositoryInterface;

class GreetingService
{
    public function __construct(
        private GreetingRepositoryInterface $greetingRepository
    ){}

    public function createGreeting(int $creatorId, array $data): Greeting
    {
        $data['creator_id'] = $creatorId;
        $data['status'] = 'draft';
        
        return $this->greetingRepository->create($data);
    }

    public function scheduleGreeting(Greeting $greeting, string $scheduledAt): bool
    {
        return $this->greetingRepository->update($greeting, [
            'is_scheduled' => true,
            'scheduled_at' => $scheduledAt,
            'status' => 'scheduled'
        ]);
    }

    public function sendGreeting(Greeting $greeting): bool
    {
        // Logic for sending greeting
        $result = $this->greetingRepository->update($greeting, [
            'status' => 'sent'
        ]);
        
        if ($result) {
            $greeting->markAsSent();
        }
        
        return $result;
    }

    // ... additional business logic methods
}
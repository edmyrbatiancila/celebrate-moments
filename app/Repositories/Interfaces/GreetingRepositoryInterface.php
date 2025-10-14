<?php

namespace App\Repositories\Interfaces;

use App\Models\Greeting;
use Illuminate\Database\Eloquent\Collection;

interface GreetingRepositoryInterface
{
    public function getAllGreetings(): Collection;

    public function getGreetingsByCreator(int $creatorId): Collection;

    public function getGreetingsByRecipient(int $recipientId): Collection;

    public function getGreetingsByStatus(string $status): Collection;

    public function findById(int $id): ?Greeting;

    public function create(array $data): Greeting;

    public function update(Greeting $greeting, array $data): bool;

    public function delete(Greeting $greeting): bool;

    public function getScheduledGreetings(): Collection;

    public function markAsDelivered(Greeting $greeting): bool;
}

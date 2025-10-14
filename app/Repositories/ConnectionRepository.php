<?php

namespace App\Repositories;

use App\Models\Connection;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ConnectionRepository implements ConnectionRepositoryInterface
{
    public function getAllConnections(): Collection
    {
        return Connection::with(['requester', 'receiver'])->get();
    }

    public function getConnectionById(int $id): ?Connection
    {
        try {
            return Connection::with(['requester', 'receiver'])->find($id);
        } catch (\Exception $e) {
            Log::error("Error finding Connection by ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function createConnection(array $data): Connection
    {
        return Connection::create($data);
    }

    public function updateConnection(int $id, array $data): bool
    {
        try {
            $connection = Connection::findOrFail($id);
            return $connection->update($data);
        } catch (\Exception $e) {
            Log::error("Error updating Connection ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function deleteConnection(int $id): bool
    {
        try {
            $connection = Connection::findOrFail($id);
            return $connection->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting Connection ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    // Additional specific methods
    public function getConnectionsByUser(int $userId): Collection
    {
        return Connection::with(['requester', 'receiver'])
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getConnectionsByStatus(string $status): Collection
    {
        return Connection::with(['requester', 'receiver'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPendingConnections(int $userId): Collection
    {
        return Connection::with(['requester', 'receiver'])
            ->where('receiver_id', $userId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAcceptedConnections(int $userId): Collection
    {
        return Connection::with(['requester', 'receiver'])
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->orderBy('connected_at', 'desc')
            ->get();
    }
}
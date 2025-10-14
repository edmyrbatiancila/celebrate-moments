<?php

namespace App\Services;

use App\Models\Connection;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ConnectionService
{
    public function __construct(
        private ConnectionRepositoryInterface $connectionRepository
    ) {}

    public function sendConnectionRequest(int $requesterId, int $receiverId): Connection
    {
        $data = [
            'requester_id' => $requesterId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
            'requested_at' => now(),
        ];

        return $this->connectionRepository->createConnection($data);
    }

    public function acceptConnection(Connection $connection): bool
    {
        $data = [
            'status' => 'accepted',
            'connected_at' => now(),
        ];

        return $this->connectionRepository->updateConnection($connection->id, $data);
    }

    public function blockConnection(Connection $connection, int $blockerId): bool
    {
        $data = [
            'status' => 'blocked',
            'blocked_by' => $blockerId,
            'blocked_at' => now(),
        ];

        return $this->connectionRepository->updateConnection($connection->id, $data);
    }

    public function unblockConnection(Connection $connection): bool
    {
        $data = [
            'status' => 'accepted',
            'blocked_by' => null,
            'blocked_at' => null,
        ];

        return $this->connectionRepository->updateConnection($connection->id, $data);
    }

    public function canViewConnection(int $userId, Connection $connection): bool
    {
        return $connection->requester_id === $userId || $connection->receiver_id === $userId;
    }

    public function getUserFriends(int $userId): Collection
    {
        return Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
        ->where('status', 'accepted')
        ->with(['requester', 'receiver'])
        ->get()
        ->map(function ($connection) use ($userId) {
            // Return the other user (not the current user)
            return $connection->requester_id === $userId 
                ? $connection->receiver 
                : $connection->requester;
        });
    }

    public function getPendingRequests(int $userId): Collection
    {
        return Connection::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->with(['requester'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function areUsersFriends(int $userId1, int $userId2): bool
    {
        return Connection::where(function ($query) use ($userId1, $userId2) {
            $query->where('requester_id', $userId1)
                ->where('receiver_id', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('requester_id', $userId2)
                ->where('receiver_id', $userId1);
        })
        ->where('status', 'accepted')
        ->exists();
    }

    public function getConnectionStats(int $userId): array
    {
        $connections = Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                ->orWhere('receiver_id', $userId);
        })->get();

        return [
            'total_friends' => $connections->where('status', 'accepted')->count(),
            'pending_sent' => $connections->where('requester_id', $userId)
                                        ->where('status', 'pending')->count(),
            'pending_received' => $connections->where('receiver_id', $userId)
                                            ->where('status', 'pending')->count(),
            'blocked' => $connections->where('status', 'blocked')->count(),
        ];
    }
}
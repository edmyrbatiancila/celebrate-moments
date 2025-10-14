<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use App\Services\ConnectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function __construct(
        private ConnectionRepositoryInterface $repository,
        private ConnectionService $service
    ) {}

    /**
     * Display a listing of user's connections.
     */
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|string|in:pending,accepted,blocked',
            'type' => 'nullable|string|in:sent,received,all'
        ]);

        $userId = Auth::id();
        $status = $request->status;
        $type = $request->type ?? 'all';

        // Get connections based on type
        $query = Connection::query();

        if ($type === 'sent') {
            $query->where('requester_id', $userId);
        } elseif ($type === 'received') {
            $query->where('receiver_id', $userId);
        } else {
            $query->where(function ($q) use ($userId) {
                $q->where('requester_id', $userId)
                    ->orWhere('receiver_id', $userId);
            });
        }

        // Filter by status if provided
        if ($status) {
            $query->where('status', $status);
        }

        $connections = $query->with(['requester', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'connections' => $connections->items(),
            'pagination' => [
                'current_page' => $connections->currentPage(),
                'total_pages' => $connections->lastPage(),
                'total_items' => $connections->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id|different:' . Auth::id(),
        ]);

        $receiverId = $request->receiver_id;
        $requesterId = Auth::id();

        // Check if connection already exists
        $existingConnection = Connection::where(function ($query) use ($requesterId, $receiverId) {
            $query->where('requester_id', $requesterId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($requesterId, $receiverId) {
            $query->where('requester_id', $receiverId)
                    ->where('receiver_id', $requesterId);
        })->first();

        if ($existingConnection) {
            return response()->json([
                'message' => 'Connection request already exists or users are already connected'
            ], 409);
        }

        try {
            $connection = $this->service->sendConnectionRequest($requesterId, $receiverId);
            
            return response()->json([
                'message' => 'Connection request sent successfully',
                'connection' => $connection->load(['requester', 'receiver'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send connection request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Connection $connection)
    {
        // Only users involved in the connection can view it
        if (!$this->service->canViewConnection(Auth::id(), $connection)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'connection' => $connection->load(['requester', 'receiver'])
        ]);
    }

    public function accept(Connection $connection)
    {
        // Only the receiver can accept the connection
        if (Auth::id() !== $connection->receiver_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($connection->status !== 'pending') {
            return response()->json([
                'message' => 'Connection request is not pending'
            ], 400);
        }

        try {
            $accepted = $this->service->acceptConnection($connection);
            
            if ($accepted) {
                return response()->json([
                    'message' => 'Connection request accepted',
                    'connection' => $connection->fresh()->load(['requester', 'receiver'])
                ]);
            }

            return response()->json([
                'message' => 'Failed to accept connection request'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to accept connection request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Connection $connection)
    {
        // Only users involved in the connection can update it
        if (!$this->service->canViewConnection(Auth::id(), $connection)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|string|in:blocked,accepted'
        ]);

        try {
            if ($request->status === 'blocked') {
                $updated = $this->service->blockConnection($connection, Auth::id());
            } else {
                $updated = $this->service->unblockConnection($connection);
            }
            
            if ($updated) {
                return response()->json([
                    'message' => 'Connection updated successfully',
                    'connection' => $connection->fresh()->load(['requester', 'receiver'])
                ]);
            }

            return response()->json([
                'message' => 'Failed to update connection'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update connection',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Connection $connection)
    {
        // Only users involved in the connection can delete it
        if (!$this->service->canViewConnection(Auth::id(), $connection)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $deleted = $this->repository->deleteConnection($connection->id);
            
            if ($deleted) {
                return response()->json([
                    'message' => 'Connection removed successfully'
                ]);
            }

            return response()->json([
                'message' => 'Failed to remove connection'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to remove connection',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's friends (accepted connections)
     */
    public function friends()
    {
        try {
            $friends = $this->service->getUserFriends(Auth::id());
            
            return response()->json([
                'friends' => $friends,
                'count' => $friends->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get friends list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pending connection requests
     */
    public function pending()
    {
        try {
            $pendingRequests = $this->service->getPendingRequests(Auth::id());
            
            return response()->json([
                'pending_requests' => $pendingRequests,
                'count' => $pendingRequests->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get pending requests',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

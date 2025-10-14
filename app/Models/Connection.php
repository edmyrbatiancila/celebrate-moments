<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    /** @use HasFactory<\Database\Factories\ConnectionFactory> */
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'receiver_id',
        'status', // pending, accepted, rejected, blocked
        'connected_at'
    ];

    protected function casts(): array
    {
        return [
            'connected_at' => 'datetime'
        ];
    }

    public static function validationRules()
    {
        return [
            'requester_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id|different:requester_id',
            'status' => 'required|in:pending,accepted,declined,blocked',
            'connected_at' => 'nullable|date',
        ];
    }

    // Relationships
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Helper Methods
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    public function accept(): bool
    {
        return $this->update([
            'status' => 'accepted',
            'connected_at' => now()
        ]);
    }

    public function decline(): bool
    {
        return $this->update(['status' => 'declined']);
    }

    public function block(): bool
    {
        return $this->update(['status' => 'blocked']);
    }
}

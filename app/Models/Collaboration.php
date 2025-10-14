<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    /** @use HasFactory<\Database\Factories\CollaborationFactory> */
    use HasFactory;

    protected $fillable = [
        'greeting_id',
        'collaborator_id',
        'role',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'role' => 'string',
            'status' => 'string'
        ];
    }

    public static function validationRules()
    {
        return [
            'greeting_id' => 'required|exists:greetings,id',
            'collaborator_id' => 'required|exists:users,id',
            'role' => 'required|in:editor,contributor,viewer',
            'status' => 'required|in:invited,accepted,declined',
        ];
    }

    // Relationships
    public function greeting()
    {
        return $this->belongsTo(Greeting::class);
    }

    public function collaborator()
    {
        return $this->belongsTo(User::class, 'collaborator_id');
    }

    // Helper Methods
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isContributor(): bool
    {
        return $this->role === 'contributor';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function accept(): bool
    {
        return $this->update(['status' => 'accepted']);
    }

    public function decline(): bool
    {
        return $this->update(['status' => 'declined']);
    }
}

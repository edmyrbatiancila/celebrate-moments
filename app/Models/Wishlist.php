<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    /** @use HasFactory<\Database\Factories\WishlistFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creator_id',
        'greeting_type',
        'occasion',
        'budget_range',
        'description'
    ];

    protected function casts(): array
    {
        return [
            'budget_range' => 'array'
        ];
    }

    public static function validationRules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'creator_id' => 'nullable|exists:users,id',
            'greeting_type' => 'required|in:video,audio,text,mixed',
            'occasion' => 'required|string|max:100',
            'budget_range' => 'nullable|array',
            'description' => 'nullable|string|max:500',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Helper Methods
    public function hasBudget(): bool
    {
        return !is_null($this->budget_range) && !empty($this->budget_range);
    }

    public function getBudgetRange(): string
    {
        if (!$this->hasBudget()) {
            return 'No budget specified';
        }
        
        return '$' . $this->budget_range['min'] . ' - $' . $this->budget_range['max'];
    }

    public function isForSpecificCreator(): bool
    {
        return !is_null($this->creator_id);
    }
}

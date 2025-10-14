<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'reviewer_id',
        'reviewee_id',
        'greeting_id',
        'rating',
        'comment',
        'is_anonymous'
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_anonymous' => 'boolean'
        ];
    }

    public static function validationRules()
    {
        return [
            'reviewer_id' => 'required|exists:users,id',
            'reviewee_id' => 'required|exists:users,id|different:reviewer_id',
            'greeting_id' => 'nullable|exists:greetings,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ];
    }

    // Relationships
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function greeting()
    {
        return $this->belongsTo(Greeting::class);
    }

    // Helper Methods
    public function isAnonymous(): bool
    {
        return $this->is_anonymous;
    }

    public function getStarDisplay(): string
    {
        return str_repeat('⭐', $this->rating);
    }

    public function isPositiveReview(): bool
    {
        return $this->rating >= 4;
    }
}

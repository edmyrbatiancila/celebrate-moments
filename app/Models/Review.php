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
}

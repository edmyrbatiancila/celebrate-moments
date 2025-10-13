<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreetingAnalytics extends Model
{
    /** @use HasFactory<\Database\Factories\GreetingAnalyticsFactory> */
    use HasFactory;

    protected $fillable = [
        'greeting_id',
        'views_count',
        'shares_count', 
        'likes_count',
        'engagement_data'
    ];

    protected function casts(): array
    {
        return [
            'engagement_data' => 'array',
        ];
    }

    public function greeting()
    {
        return $this->belongsTo(Greeting::class);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementShares()
    {
        $this->increment('shares_count');
    }

    public function incrementLikes()
    {
        $this->increment('likes_count');
    }
}

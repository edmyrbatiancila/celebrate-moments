<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    /** @use HasFactory<\Database\Factories\CreatorProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'bio', 
        'specialties', 
        'portfolio_url', 
        'experience_years',
        'pricing_tier', 
        'rating', 
        'total_greetings_created', 
        'verification_status',
        'verification_documents', 
        'social_links', 
        'availability_status'
    ];

    // Relationships TODO: Define relationships once other models are created:
    // public function user()
    // public function subscriptions()
    // public function analytics()
    // public function collaborations()
}

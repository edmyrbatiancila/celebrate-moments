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

    protected function casts(): array
    {
        return [
            'specialties' => 'array',
            'verification_documents' => 'array',
            'social_links' => 'array',
            'rating' => 'decimal:2',
            'availability_status' => 'boolean',
        ];
    }

    public static function validationRules()
    {
        return [
            'bio' => 'nullable|string|max:1000',
            'specialties' => 'nullable|array',
            'portfolio_url' => 'nullable|url',
            'experience_years' => 'integer|min:0|max:50',
            'pricing_tier' => 'in:free,basic,premium,enterprise',
            'social_links' => 'nullable|array',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function greetings()
    {
        return $this->hasMany(Greeting::class, 'creator_id', 'user_id');
    }

    public function templates()
    {
        return $this->hasMany(Template::class, 'creator_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id', 'user_id');
    }

    public function collaborations()
    {
        return $this->hasMany(Collaboration::class, 'collaborator_id', 'user_id');
    }

    // Helper Methods
    public function isVerified()
    {
        return $this->verification_status === 'approved';
    }

    public function isAvailable()
    {
        return $this->availability_status;
    }

    public function getAverageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function incrementGreetingsCount()
    {
        $this->increment('total_greetings_created');
    }
}

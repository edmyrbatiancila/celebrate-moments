<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /** @use HasFactory<\Database\Factories\TemplateFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'category', 
        'content_structure', 
        'preview_image',
        'is_premium', 
        'creator_id', 
        'usage_count', 
        'rating'
    ];

    protected function casts(): array
    {
        return [
            'content_structure' => 'array',
            'is_premium' => 'boolean',
            'rating' => 'decimal:2',
        ];
    }

    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'content_structure' => 'required|array',
            'preview_image' => 'nullable|string',
            'is_premium' => 'boolean',
            'creator_id' => 'nullable|exists:users,id',
        ];
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function greetings()
    {
        return $this->hasMany(Greeting::class);
    }

    // Helpers Methods:

    public function isPremium()
    {
        return $this->is_premium;
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}

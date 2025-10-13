<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Greeting extends Model
{
    /** @use HasFactory<\Database\Factories\GreetingFactory> */
    use HasFactory;

    protected $fillable = [
        'creator_id', 
        'title', 
        'description', 
        'greeting_type', 
        'occasion_type',
        'content_type', 
        'content_data', 
        'template_id', 
        'theme_settings',
        'is_scheduled', 
        'scheduled_at', 
        'status', 
        'is_collaborative'
    ];

    // Relationships TODO: Define relationships once other models are created:
    // public function creator()
    // public function recipients()
    // public function media()
    // public function template()
    // public function analytics()
    // public function collaborators()
    // public function thankYouResponses()
}

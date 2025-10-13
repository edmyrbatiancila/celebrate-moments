<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'filename', 
        'original_name', 
        'mime_type', 
        'size',
        'file_path', 
        'thumbnail_path', 
        'media_type', 
        'duration', 
        'metadata'
    ];

    // Relationships TODO: Define relationships once other models are created:
    // public function user()
    // public function greetings()
}

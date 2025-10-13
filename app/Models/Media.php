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

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'size' => 'integer',
            'duration' => 'integer'
        ];
    }

    public static function validationRules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'filename' => 'required|string|max:255',
            'original_name' => 'required|string|max:255',
            'mime_type' => 'required|string|max:100',
            'size' => 'required|integer|min:1',
            'file_path' => 'required|string|max:500',
            'thumbnail_path' => 'nullable|string|max:500',
            'media_type' => 'required|in:image,video,audio,document',
            'duration' => 'nullable|integer|min:0',
            'metadata' => 'nullable|array'
        ];
    }

    // Relationships 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function greetings()
    {
        return $this->belongsToMany(Greeting::class, 'greeting_media')
            ->withPivot('order')
            ->withTimestamps();
    }

    // Helper methods:
    public function isImage(): bool
    {
        return $this->media_type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'video';
    }

    public function isAudio(): bool
    {
        return $this->media_type === 'audio';
    }

    public function getFormattedSize(): string
    {
        $size = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < 3; $i++) {
            $size /= 1024;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getFormattedDuration(): ?string
    {
        if (!$this->duration) return null;
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function generateThumbnail(): bool
    {
        // Logic to generate thumbnail would go here
        // For now, return true as placeholder
        return true;
    }
}

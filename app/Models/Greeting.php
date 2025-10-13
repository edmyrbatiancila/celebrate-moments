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

    protected function casts(): array
    {
        return [
            'content_data' => 'array',
            'theme_settings' => 'array',
            'scheduled_at' => 'datetime',
            'is_scheduled' => 'boolean',
            'is_collaborative' => 'boolean',
        ];
    }

    public static function validationRules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'greeting_type' => 'required|in:video,audio,text,mixed',
            'occasion_type' => 'required|in:birthday,anniversary,holiday,graduation,custom',
            'content_type' => 'required|in:personal,template_based,ai_generated',
            'content_data' => 'required|array',
            'template_id' => 'nullable|exists:templates,id',
            'theme_settings' => 'nullable|array',
            'scheduled_at' => 'nullable|date|after:now',
            'is_scheduled' => 'boolean',
            'is_collaborative' => 'boolean',
        ];
    }

    // Relationships

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'greeting_recipients', 'greeting_id', 'recipient_id')
            ->withPivot('sent_at', 'delivered_at', 'viewed_at', 'is_thanked', 'thank_you_message')
            ->withTimestamps();
    }

    public function media()
    {
        return $this->belongToMany(Media::class, 'greeting_media')
            ->withPivot('order')
            ->withTimtestamps()
            ->orderBy('pivot_order');
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function analytics()
    {
        return $this->hasOne(GreetingAnalytics::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborations', 'greeting_id', 'collaborator_id')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function thankYouResponses()
    {
        return $this->hasMany(GreetingRecipient::class)
            ->whereNotNull('thank_you_message');
    }

    // Helper Methods:
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isSent()
    {
        return in_array($this->status, ['sent', 'delivered', 'viewed']);
    }

    public function isDelivered()
    {
        return in_array($this->status, ['delivered', 'viewed']);
    }

    public function isViewed()
    {
        return $this->status === 'viewed';
    }

    // Action methods:
    public function markAsSent()
    {
        $this->update(['status' => 'sent']);
    }

    public function markAsDelivered()
    {
        $this->update(['status' => 'delivered']);
    }

    public function markAsViewed()
    {
        $this->update(['status' => 'viewed']);
    }

    // Content methods
    public function hasMedia()
    {
        return $this->media()->exists();
    }

    public function getMediaByType(string $type)
    {
        return $this->media()->where('media_type', $type)->get();
    }

    public function addRecipient(int $userId)
    {
        return $this->recipients()->attach($userId, [
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

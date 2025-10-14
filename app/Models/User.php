<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'timezone',
        'is_creator',
        'is_verified_creator',
        'current_role',
        'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'creator_upgraded_at' => 'datetime',
            'is_creator' => 'boolean',
            'is_verified_creator' => 'boolean',
            'specialties' => 'array',
        ];
    }

    // Relationships
    public function creatorProfile()
    {
        return $this->hasOne(CreatorProfile::class);
    }
    public function greetingsCreated()
    {
        return $this->hasMany(Greeting::class, 'creator_id');
    }
    public function greetingsReceived()
    {
        return $this->belongsToMany(Greeting::class, 'greeting_recipients', 'recipient_id', 'greeting_id')
            ->withPivot('sent_at', 'delivered_at', 'viewed_at', 'is_thanked', 'thank_you_message')
            ->withTimestamps();
    }
    public function connectionsRequested()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    public function connectionsReceived()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    // Helper methods for role management:
    public function isCreator(): bool
    {
        return $this->is_creator;
    }

    public function isVerifiedCreator(): bool
    {
        return $this->is_verified_creator;
    }

    public function canCreateGreetings()
    {
        return $this->is_creator && $this->current_role === "creator";
    }

    public function switchToCreatorRole()
    {
        $this->current_role = 'creator';
        $this->save();
    }

    public function switchToCelebrantRole()
    {
        $this->current_role = 'celebrant';
        $this->save();
    }

    public function upgradeToCreator()
    {
        $this->is_creator = true;
        $this->creator_upgraded_at = now();
        $this->save();

        // Create creator profile
        $this->creatorProfile()->create([
            'bio' => null,
            'verification_status' => 'pending'
        ]);
    }

}
<?php

namespace App\Policies;

use App\Models\Greeting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GreetingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view greetings list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Greeting $greeting): bool
    {
        // Creator can view their own greetings, recipients can view greetings sent to them
        return $user->id === $greeting->creator_id || 
            $greeting->recipients()->where('recipient_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_creator; // Only creators can create greetings
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Greeting $greeting): bool
    {
        return $user->id === $greeting->creator_id; // Only the creator can update their greeting
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Greeting $greeting): bool
    {
        return $user->id === $greeting->creator_id; // Only the creator can delete their greeting
    }

    /**
     * Determine whether the user can send the greeting.
     */
    public function send(User $user, Greeting $greeting): bool
    {
        return $user->id === $greeting->creator_id && $greeting->status === 'draft';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Greeting $greeting): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Greeting $greeting): bool
    {
        return false;
    }
}

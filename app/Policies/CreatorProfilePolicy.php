<?php

namespace App\Policies;

use App\Models\CreatorProfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CreatorProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CreatorProfile $creatorProfile): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_creator && !$user->creatorProfile; // Only creators without a profile can create one
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->id === $creatorProfile->user_id; // Only the owner can update their profile
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CreatorProfile $creatorProfile): bool
    {
        return $user->id === $creatorProfile->user_id; // Only the owner can delete their profile
    }

    /**
     * Determine whether the user can verify creator profiles.
     */
    public function verify(User $user): bool
    {
        // Add admin check logic here if you have admin roles
        return false; // For now, no one can verify (implement admin logic later)
    }

    /**
     * Determine whether the user can reject creator profiles.
     */
    public function reject(User $user): bool
    {
        // Add admin check logic here if you have admin roles
        return false; // For now, no one can reject (implement admin logic later)
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CreatorProfile $creatorProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CreatorProfile $creatorProfile): bool
    {
        return false;
    }
}

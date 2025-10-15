<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreatorProfile;
use App\Repositories\Interfaces\CreatorProfileRepositoryInterface;
use App\Services\CreatorProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatorProfileController extends Controller
{
    public function __construct(
        private CreatorProfileRepositoryInterface $repository,
        private CreatorProfileService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $verified = $request->query('verified', false);
        
        $creators = $verified 
            ? $this->repository->getVerifiedCreators()
            : $this->repository->getAllCreators();

        return response()->json([
            'creators' => $creators,
            'total' => $creators->count()
        ]);
    }

    /**
     * Store a newly created resource in storage or update existing profile.
     */
    public function store(Request $request)
    {
        // Only authenticated users who are creators can create/update profiles
        if (!Auth::user()->is_creator) {
            return response()->json([
                'message' => 'Only creators can create creator profiles'
            ], 403);
        }

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string|in:birthday,anniversary,holiday,wedding,graduation,custom',
            'portfolio_url' => 'nullable|url',
            'availability_status' => 'boolean',
        ]);

        try {
            // Check if user already has a profile
            $existingProfile = $this->repository->findByUserId(Auth::id());
            
            if ($existingProfile) {
                // Update existing profile
                $updated = $this->service->updateProfile($existingProfile, $validated);
                
                if ($updated) {
                    return response()->json([
                        'message' => 'Creator profile updated successfully',
                        'profile' => $existingProfile->fresh()->load('user')
                    ], 200);
                }
                
                return response()->json([
                    'message' => 'Failed to update creator profile'
                ], 500);
            } else {
                // Create new profile
                $profile = $this->service->createProfile(Auth::id(), $validated);
                
                return response()->json([
                    'message' => 'Creator profile created successfully',
                    'profile' => $profile->load('user')
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create/update creator profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CreatorProfile $creatorProfile)
    {
        return response()->json([
            'profile' => $creatorProfile->load(['user', 'greetings', 'templates'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CreatorProfile $creatorProfile)
    {
        // Only the profile owner can update
        if (Auth::id() !== $creatorProfile->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'bio' => 'sometimes|nullable|string|max:1000',
            'specialties' => 'sometimes|nullable|array',
            'specialties.*' => 'string|in:birthday,anniversary,holiday,wedding,graduation,custom',
            'portfolio_url' => 'sometimes|nullable|url',
            'hourly_rate' => 'sometimes|nullable|numeric|min:0',
            'availability_status' => 'sometimes|boolean',
        ]);

        try {
            $updated = $this->service->updateProfile($creatorProfile, $request->validated());
            
            if ($updated) {
                return response()->json([
                    'message' => 'Creator profile updated successfully',
                    'profile' => $creatorProfile->fresh()->load('user')
                ]);
            }

            return response()->json([
                'message' => 'Failed to update creator profile'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update creator profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreatorProfile $creatorProfile)
    {
        // Only the profile owner can delete
        if (Auth::id() !== $creatorProfile->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $deleted = $this->repository->delete($creatorProfile);
            
            if ($deleted) {
                return response()->json([
                    'message' => 'Creator profile deleted successfully'
                ]);
            }

            return response()->json([
                'message' => 'Failed to delete creator profile'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete creator profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify a creator profile (admin only - implement admin middleware later)
     */
    public function verify(CreatorProfile $creatorProfile)
    {
        try {
            $verified = $this->service->verifyCreator($creatorProfile);
            
            if ($verified) {
                return response()->json([
                    'message' => 'Creator verified successfully',
                    'profile' => $creatorProfile->fresh()
                ]);
            }

            return response()->json([
                'message' => 'Failed to verify creator'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to verify creator',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a creator profile (admin only - implement admin middleware later)
     */
    public function reject(Request $request, CreatorProfile $creatorProfile)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        try {
            $rejected = $this->service->rejectCreator($creatorProfile, $request->reason);
            
            if ($rejected) {
                return response()->json([
                    'message' => 'Creator verification rejected',
                    'profile' => $creatorProfile->fresh()
                ]);
            }

            return response()->json([
                'message' => 'Failed to reject creator'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to reject creator',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the current authenticated user's creator profile.
     */
    public function myProfile()
    {
        if (!Auth::user()->is_creator) {
            return response()->json([
                'message' => 'Only creators can access creator profiles'
            ], 403);
        }

        $profile = $this->repository->findByUserId(Auth::id());
        
        if (!$profile) {
            return response()->json([
                'message' => 'Creator profile not found',
                'has_profile' => false
            ], 404);
        }

        return response()->json([
            'profile' => $profile->load(['user', 'greetings', 'templates']),
            'stats' => $this->service->getCreatorStats($profile),
            'has_profile' => true
        ]);
    }
}

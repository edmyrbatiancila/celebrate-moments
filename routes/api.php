<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\CreatorProfileController;
use App\Http\Controllers\Api\GreetingController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    // User management
    Route::apiResource('users', UserController::class);

    // Creator Profiles
    Route::apiResource('creator-profiles', CreatorProfileController::class);
    Route::post('creator-profiles/{creatorProfile}/verify', [CreatorProfileController::class, 'verify']);
    Route::post('creator-profiles/{creatorProfile}/reject', [CreatorProfileController::class, 'reject']);

    // Greetings management
    Route::apiResource('greetings', GreetingController::class);
    Route::post('greetings/{greeting}/send', [GreetingController::class, 'send']);
    Route::get('greetings/{greeting}/analytics', [GreetingController::class, 'analytics']);

     // Templates
    Route::apiResource('templates', TemplateController::class);
    Route::get('templates/category/{category}', [TemplateController::class, 'byCategory']);
    Route::get('templates/recommended', [TemplateController::class, 'recommended']);
    
    // Media management
    Route::apiResource('media', MediaController::class);
    Route::post('media/upload', [MediaController::class, 'upload']);
    
    // Connections (social features)
    Route::apiResource('connections', ConnectionController::class);
    Route::post('connections/{connection}/accept', [ConnectionController::class, 'accept']);
    Route::get('connections/friends', [ConnectionController::class, 'friends']);
    Route::get('connections/pending', [ConnectionController::class, 'pending']);
    
    // Reviews
    Route::apiResource('reviews', ReviewController::class);
    Route::get('users/{user}/reviews', [ReviewController::class, 'userReviews']);
    Route::get('users/{user}/review-stats', [ReviewController::class, 'stats']);
    Route::get('reviews/top-rated', [ReviewController::class, 'topRated']);
    
    // Analytics
    Route::get('analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    Route::get('analytics/platform', [AnalyticsController::class, 'platformStats']);
});
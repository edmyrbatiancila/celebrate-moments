<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Models\Greeting;
use App\Models\GreetingAnalytics;
use App\Models\Review;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Get dashboard analytics for authenticated user
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        if ($user->is_creator) {
            return $this->creatorDashboard($user, $request);
        } else {
            return $this->userDashboard($user, $request);
        }
    }

    /**
     * Get creator-specific analytics
     */
    private function creatorDashboard(User $user, Request $request)
    {
        $request->validate([
            'period' => 'nullable|string|in:week,month,quarter,year',
        ]);

        $period = $request->period ?? 'month';
        $startDate = $this->getStartDate($period);

        // Basic creator stats
        $totalGreetings = Greeting::where('creator_id', $user->id)->count();
        $totalViews = GreetingAnalytics::whereHas('greeting', function($query) use ($user) {
            $query->where('creator_id', $user->id);
        })->sum('views_count');

        $totalShares = GreetingAnalytics::whereHas('greeting', function($query) use ($user) {
            $query->where('creator_id', $user->id);
        })->sum('shares_count');
        
        $totalLikes = GreetingAnalytics::whereHas('greeting', function($query) use ($user) {
            $query->where('creator_id', $user->id);
        })->sum('likes_count');

        // Reviews stats
        $reviewStats = Review::where('reviewee_id', $user->id)
            ->selectRaw('
                COUNT(*) as total_reviews,
                AVG(rating) as average_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star_count,
                SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) as four_plus_star_count
            ')
            ->first();

        // Period-specific analytics
        $periodGreetings = Greeting::where('creator_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->count();
            
        $periodReviews = Review::where('reviewee_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->count();

        // Top performing greetings
        $topGreetings = Greeting::where('creator_id', $user->id)
            ->with(['analytics'])
            ->get()
            ->sortByDesc(function($greeting) {
                return $greeting->analytics->views_count ?? 0;
            })
            ->take(5)
            ->values();

        // Recent activity
        $recentActivity = $this->getCreatorRecentActivity($user, 10);

        // Templates usage
        $templatesUsage = Template::where('creator_id', $user->id)
            ->orderBy('usage_count', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'user_type' => 'creator',
            'overview' => [
                'total_greetings' => $totalGreetings,
                'total_views' => $totalViews,
                'total_shares' => $totalShares,
                'total_likes' => $totalLikes,
                'period_greetings' => $periodGreetings,
                'period_reviews' => $periodReviews,
            ],
            'reviews' => [
                'total_reviews' => $reviewStats->total_reviews ?? 0,
                'average_rating' => round($reviewStats->average_rating ?? 0, 2),
                'five_star_count' => $reviewStats->five_star_count ?? 0,
                'four_plus_star_count' => $reviewStats->four_plus_star_count ?? 0,
            ],
            'top_greetings' => $topGreetings,
            'recent_activity' => $recentActivity,
            'templates_usage' => $templatesUsage,
            'period' => $period,
            'period_start' => $startDate->format('Y-m-d'),
        ]);
    }

    /**
     * Get user-specific analytics
     */
    private function userDashboard(User $user, Request $request)
    {
        $request->validate([
            'period' => 'nullable|string|in:week,month,quarter,year',
        ]);

        $period = $request->period ?? 'month';
        $startDate = $this->getStartDate($period);

        // Received greetings
        $totalReceived = DB::table('greeting_recipients')
            ->where('recipient_id', $user->id)
            ->count();
            
        $periodReceived = DB::table('greeting_recipients')
            ->where('recipient_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->count();

        // Connections stats
        $totalConnections = Connection::where(function($query) use ($user) {
            $query->where('requester_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })
        ->where('status', 'accepted')
        ->count();

        $pendingConnections = Connection::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Reviews given
        $reviewsGiven = Review::where('reviewer_id', $user->id)->count();
        $periodReviews = Review::where('reviewer_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->count();

        // Recent greetings received
        $recentGreetings = DB::table('greeting_recipients')
            ->join('greetings', 'greeting_recipients.greeting_id', '=', 'greetings.id')
            ->join('users', 'greetings.creator_id', '=', 'users.id')
            ->where('greeting_recipients.recipient_id', $user->id)
            ->select([
                'greetings.id',
                'greetings.title',
                'greetings.greeting_type',
                'users.name as creator_name',
                'greeting_recipients.created_at as received_at'
            ])
            ->orderBy('greeting_recipients.created_at', 'desc')
            ->take(5)
            ->get();

        // Favorite creators (most greetings received from)
        $favoriteCreators = DB::table('greeting_recipients')
            ->join('greetings', 'greeting_recipients.greeting_id', '=', 'greetings.id')
            ->join('users', 'greetings.creator_id', '=', 'users.id')
            ->where('greeting_recipients.recipient_id', $user->id)
            ->select([
                'users.id',
                'users.name',
                DB::raw('COUNT(*) as greetings_count')
            ])
            ->groupBy('users.id', 'users.name')
            ->orderBy('greetings_count', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'user_type' => 'celebrant',
            'overview' => [
                'total_received' => $totalReceived,
                'period_received' => $periodReceived,
                'total_connections' => $totalConnections,
                'pending_connections' => $pendingConnections,
                'reviews_given' => $reviewsGiven,
                'period_reviews' => $periodReviews,
            ],
            'recent_greetings' => $recentGreetings,
            'favorite_creators' => $favoriteCreators,
            'period' => $period,
            'period_start' => $startDate->format('Y-m-d'),
        ]);
    }

    /**
     * Get platform-wide analytics (admin only)
     */
    public function platformStats(Request $request)
    {
        // You can add admin authorization here if needed
        
        $totalUsers = User::count();
        $totalCreators = User::where('is_creator', true)->count();
        $verifiedCreators = User::where('is_verified_creator', true)->count();
        $totalGreetings = Greeting::count();
        $totalReviews = Review::count();
        $totalConnections = Connection::where('status', 'accepted')->count();

        // Growth metrics (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        
        $newUsers = User::where('created_at', '>=', $thirtyDaysAgo)->count();
        $newGreetings = Greeting::where('created_at', '>=', $thirtyDaysAgo)->count();
        $newReviews = Review::where('created_at', '>=', $thirtyDaysAgo)->count();

        // Top creators by greetings
        $topCreatorsByGreetings = User::where('is_creator', true)
            ->withCount('greetings')
            ->orderBy('greetings_count', 'desc')
            ->take(10)
            ->get();

        // Top creators by rating
        $topCreatorsByRating = User::where('is_creator', true)
            ->where('is_verified_creator', true)
            ->with('creatorProfile')
            ->get()
            ->sortByDesc(function($user) {
                return $user->creatorProfile->rating ?? 0;
            })
            ->take(10)
            ->values();

        return response()->json([
            'overview' => [
                'total_users' => $totalUsers,
                'total_creators' => $totalCreators,
                'verified_creators' => $verifiedCreators,
                'total_greetings' => $totalGreetings,
                'total_reviews' => $totalReviews,
                'total_connections' => $totalConnections,
            ],
            'growth' => [
                'new_users_30d' => $newUsers,
                'new_greetings_30d' => $newGreetings,
                'new_reviews_30d' => $newReviews,
            ],
            'top_creators_by_greetings' => $topCreatorsByGreetings,
            'top_creators_by_rating' => $topCreatorsByRating,
        ]);
    }

    /**
     * Get start date based on period
     */
    private function getStartDate(string $period): Carbon
    {
        return match($period) {
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'quarter' => Carbon::now()->subQuarter(),
            'year' => Carbon::now()->subYear(),
            default => Carbon::now()->subMonth(),
        };
    }

    /**
     * Get recent activity for creators
     */
    private function getCreatorRecentActivity(User $user, int $limit = 10): array
    {
        $activities = collect();

        // Recent greetings
        $recentGreetings = Greeting::where('creator_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function($greeting) {
                return [
                    'type' => 'greeting_created',
                    'description' => "Created greeting: {$greeting->title}",
                    'timestamp' => $greeting->created_at,
                    'data' => $greeting
                ];
            });

        // Recent reviews received
        $recentReviews = Review::where('reviewee_id', $user->id)
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function($review) {
                return [
                    'type' => 'review_received',
                    'description' => "Received {$review->rating}-star review from {$review->reviewer->name}",
                    'timestamp' => $review->created_at,
                    'data' => $review
                ];
            });

        $activities = $activities->merge($recentGreetings)->merge($recentReviews);

        return $activities->sortByDesc('timestamp')->take($limit)->values()->toArray();
    }
}

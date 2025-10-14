<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Greeting;
use App\Repositories\Interfaces\GreetingRepositoryInterface;
use App\Services\GreetingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GreetingController extends Controller
{
    public function __construct(
        private GreetingRepositoryInterface $greetingRepository,
        private GreetingService $greetingService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->current_role === 'creator') {
            $greetings = $this->greetingRepository->getGreetingsByCreator($user->id);
        } else {
            $greetings = $this->greetingRepository->getGreetingsByRecipient($user->id);
        }

        return response()->json([
            'greetings' => $greetings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'greeting_type' => 'required|in:video,audio,text,mixed',
            'occasion_type' => 'required|string',
            'template_id' => 'nullable|exists:templates,id',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'exists:users,id',
        ]);

        $greeting = $this->greetingService->createGreeting(
            Auth::id(),
            $request->except('recipients')
        );

        // Attach recipients
        $greeting->recipients()->attach($request->recipients);

        return response()->json([
            'message' => 'Greeting created successfully',
            'greeting' => $greeting->load(['recipients', 'template', 'media'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Greeting $greeting)
    {
        $this->authorize('view', $greeting);

        return response()->json([
            'greeting' => $greeting->load(['creator', 'recipients', 'template', 'media', 'analytics'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Greeting $greeting)
    {
        $this->authorize('update', $greeting);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'greeting_type' => 'sometimes|required|in:video,audio,text,mixed',
        ]);

        $this->greetingRepository->update($greeting, $request->validated());

        return response()->json([
            'message' => 'Greeting updated successfully',
            'greeting' => $greeting->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Greeting $greeting)
    {
        $this->authorize('delete', $greeting);

        $this->greetingRepository->delete($greeting);

        return response()->json([
            'message' => 'Greeting deleted successfully'
        ]);
    }

    public function send(Request $request, Greeting $greeting)
    {
        $this->authorize('update', $greeting);

        $sent = $this->greetingService->sendGreeting($greeting);

        if ($sent) {
            return response()->json([
                'message' => 'Greeting sent successfully'
            ]);
        }

        return response()->json([
            'message' => 'Failed to send greeting'
        ], 500);
    }

    public function analytics(Greeting $greeting)
    {
        $this->authorize('view', $greeting);

        return response()->json([
            'analytics' => $greeting->analytics
        ]);
    }
}

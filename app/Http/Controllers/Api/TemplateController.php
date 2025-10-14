<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Repositories\Interfaces\TemplateRepositoryInterface;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function __construct(
        private TemplateRepositoryInterface $templateRepository,
        private TemplateService $templateService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'category' => 'nullable|string',
            'is_premium' => 'nullable|boolean',
            'creator_id' => 'nullable|integer|exists:users,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $templates = Template::query()
            ->with(['creator'])
            ->when($request->category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($request->has('is_premium'), function ($query) use ($request) {
                return $query->where('is_premium', $request->boolean('is_premium'));
            })
            ->when($request->creator_id, function ($query, $creatorId) {
                return $query->where('creator_id', $creatorId);
            })
            ->orderBy('usage_count', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'templates' => $templates->items(),
            'pagination' => [
                'current_page' => $templates->currentPage(),
                'total_pages' => $templates->lastPage(),
                'total_items' => $templates->total(),
                'per_page' => $templates->perPage(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only creators can create templates
        if (!Auth::user()->is_creator) {
            return response()->json([
                'message' => 'Only creators can create templates'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|in:birthday,anniversary,holiday,wedding,graduation,custom',
            'content_structure' => 'required|array',
            'preview_image_url' => 'nullable|url',
            'is_premium' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'theme' => 'required|string|max:100',
        ]);

        try {
            $template = $this->templateService->createTemplate(Auth::id(), $request->validated());
            
            return response()->json([
                'message' => 'Template created successfully',
                'template' => $template->load('creator')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create template',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        // Check if user can access this template
        if ($template->is_premium && !$this->templateService->canAccessTemplate(Auth::id(), $template)) {
            return response()->json([
                'message' => 'Premium template access required'
            ], 403);
        }

        // Track template usage
        $this->templateService->trackTemplateUsage($template);

        return response()->json([
            'template' => $template->load(['creator', 'greetings'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        // Only the template creator can update
        if (Auth::id() !== $template->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string|max:1000',
            'category' => 'sometimes|required|string|in:birthday,anniversary,holiday,wedding,graduation,custom',
            'content_structure' => 'sometimes|required|array',
            'preview_image_url' => 'sometimes|nullable|url',
            'is_premium' => 'sometimes|boolean',
            'price' => 'sometimes|nullable|numeric|min:0',
            'theme' => 'sometimes|required|string|max:100',
        ]);

        try {
            $updated = $template->update($request->validated());
            
            if ($updated) {
                return response()->json([
                    'message' => 'Template updated successfully',
                    'template' => $template->fresh()->load('creator')
                ]);
            }

            return response()->json([
                'message' => 'Failed to update template'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update template',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        // Only the template creator can delete
        if (Auth::id() !== $template->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $deleted = $this->templateRepository->deleteTemplate($template->id);
            
            if ($deleted) {
                return response()->json([
                    'message' => 'Template deleted successfully'
                ]);
            }

            return response()->json([
                'message' => 'Failed to delete template'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete template',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recommended templates for a user
     */
    public function recommended(Request $request)
    {
        $request->validate([
            'occasion' => 'nullable|string|in:birthday,anniversary,holiday,wedding,graduation,custom',
            'limit' => 'nullable|integer|min:1|max:20',
        ]);

        try {
            $recommendations = $this->templateService->getRecommendedTemplates(
                Auth::id(), 
                $request->occasion
            );

            return response()->json([
                'recommendations' => array_slice($recommendations, 0, $request->limit ?? 10),
                'occasion' => $request->occasion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get recommendations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get templates by category
     */
    public function byCategory(string $category)
    {
        $templates = Template::where('category', $category)
            ->with(['creator'])
            ->orderBy('usage_count', 'desc')
            ->get();

        return response()->json([
            'category' => $category,
            'templates' => $templates,
            'count' => $templates->count()
        ]);
    }
}

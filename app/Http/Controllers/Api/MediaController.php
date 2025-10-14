<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
        private MediaService $mediaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get user's media with optional filtering
        $media = $this->mediaRepository->getMediaByUser($user->id);
        
        // Apply type filter if provided
        if ($request->has('type')) {
            $media = $this->mediaRepository->getMediaByType($request->type);
        }

        return response()->json([
            'media' => $media
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'original_name' => 'required|string',
            'mime_type' => 'required|string',
            'size' => 'required|integer',
            'file_path' => 'required|string',
            'media_type' => 'required|in:image,video,audio,document',
        ]);

        $media = $this->mediaRepository->createMedia([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return response()->json([
            'message' => 'Media created successfully',
            'media' => $media
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $media = $this->mediaRepository->getMediaById($id);
        
        if (!$media) {
            return response()->json(['message' => 'Media not found'], 404);
        }

        // Check if user can view this media
        if ($media->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['media' => $media]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $media = $this->mediaRepository->getMediaById($id);
        
        if (!$media || $media->user_id !== Auth::id()) {
            return response()->json(['message' => 'Media not found'], 404);
        }

        $request->validate([
            'original_name' => 'sometimes|string',
            'alt_text' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        $updated = $this->mediaRepository->updateMedia($id, $request->validated());

        return response()->json([
            'message' => 'Media updated successfully',
            'media' => $this->mediaRepository->getMediaById($id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $media = $this->mediaRepository->getMediaById($id);
        
        if (!$media || $media->user_id !== Auth::id()) {
            return response()->json(['message' => 'Media not found'], 404);
        }

        // Delete file from storage
        Storage::delete($media->file_path);
        if ($media->thumbnail_path) {
            Storage::delete($media->thumbnail_path);
        }

        $this->mediaRepository->deleteMedia($id);

        return response()->json(['message' => 'Media deleted successfully']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // 50MB max
            'media_type' => 'required|in:image,video,audio,document',
            'alt_text' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            // Upload file and create media record
            $media = $this->mediaService->uploadFile(
                $request->file('file'),
                Auth::id(),
                $request->media_type,
                $request->alt_text,
                $request->description
            );

            return response()->json([
                'message' => 'File uploaded successfully',
                'media' => $media
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Upload failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

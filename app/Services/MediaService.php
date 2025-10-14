<?php

namespace App\Services;

use App\Repositories\Interfaces\MediaRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaService
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository
    ){}

    public function uploadFile(
        UploadedFile $file, 
        int $userId, 
        string $mediaType,
        ?string $altText = null,
        ?string $description = null
    ) {
        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Store file
        $filePath = $file->storeAs('media/' . $mediaType, $filename, 'public');
        
        // Create media record
        return $this->mediaRepository->createMedia([
            'user_id' => $userId,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'file_path' => $filePath,
            'media_type' => $mediaType,
            'alt_text' => $altText,
            'description' => $description,
        ]);
    }
}
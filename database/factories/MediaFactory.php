<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mediaType = fake()->randomElement(['image', 'video', 'audio', 'document']);

        return [
            'user_id' => User::factory(),
            'filename' => $this->generateFilename($mediaType),
            'original_name' => fake()->word() . '.' . $this->getExtensionByType($mediaType),
            'mime_type' => $this->getMimeTypeByType($mediaType),
            'size' => $this->getSizeByType($mediaType),
            'file_path' => 'storage/media/' . fake()->uuid() . '.' . $this->getExtensionByType($mediaType),
            'thumbnail_path' => $mediaType === 'video' ? 'storage/thumbnails/' . fake()->uuid() . '.jpg' : null,
            'media_type' => $mediaType,
            'duration' => in_array($mediaType, ['video', 'audio']) ? fake()->numberBetween(10, 300) : null,
            'metadata' => $this->generateMetadata($mediaType)
        ];
    }

    private function generateFilename(string $type): string
    {
        return fake()->uuid() . '.' . $this->getExtensionByType($type);
    }

    private function getExtensionByType(string $type): string
    {
        $extensions = [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'video' => ['mp4', 'mov', 'avi', 'webm'],
            'audio' => ['mp3', 'wav', 'ogg', 'm4a'],
            'document' => ['pdf', 'doc', 'docx', 'txt']
        ];
        
        return fake()->randomElement($extensions[$type]);
    }

    private function getMimeTypeByType(string $type): string
    {
        $mimeTypes = [
            'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'video' => ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm'],
            'audio' => ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4'],
            'document' => ['application/pdf', 'application/msword', 'text/plain']
        ];
        
        return fake()->randomElement($mimeTypes[$type]);
    }

    private function getSizeByType(string $type): int
    {
        $sizes = [
            'image' => [100000, 5000000], // 100KB - 5MB
            'video' => [5000000, 100000000], // 5MB - 100MB
            'audio' => [500000, 10000000], // 500KB - 10MB
            'document' => [50000, 2000000] // 50KB - 2MB
        ];
        
        return fake()->numberBetween($sizes[$type][0], $sizes[$type][1]);
    }

    private function generateMetadata(string $type): array
    {
        $baseMetadata = [
            'uploaded_at' => fake()->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'upload_ip' => fake()->ipv4()
        ];
        
        switch ($type) {
            case 'image':
                return array_merge($baseMetadata, [
                    'width' => fake()->numberBetween(500, 4000),
                    'height' => fake()->numberBetween(300, 3000),
                    'color_space' => fake()->randomElement(['RGB', 'CMYK', 'Grayscale']),
                    'has_transparency' => fake()->boolean()
                ]);
                
            case 'video':
                return array_merge($baseMetadata, [
                    'width' => fake()->randomElement([1920, 1280, 720, 480]),
                    'height' => fake()->randomElement([1080, 720, 480, 360]),
                    'fps' => fake()->randomElement([24, 30, 60]),
                    'bitrate' => fake()->numberBetween(500, 5000),
                    'codec' => fake()->randomElement(['H.264', 'H.265', 'VP9'])
                ]);
                
            case 'audio':
                return array_merge($baseMetadata, [
                    'bitrate' => fake()->randomElement([128, 192, 256, 320]),
                    'sample_rate' => fake()->randomElement([44100, 48000, 96000]),
                    'channels' => fake()->randomElement([1, 2]),
                    'codec' => fake()->randomElement(['MP3', 'AAC', 'OGG'])
                ]);
                
            default:
                return $baseMetadata;
        }
    }

    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'media_type' => 'image',
            'duration' => null,
            'thumbnail_path' => null
        ]);
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'media_type' => 'video',
            'duration' => fake()->numberBetween(30, 600),
            'thumbnail_path' => 'storage/thumbnails/' . fake()->uuid() . '.jpg'
        ]);
    }

    public function audio(): static
    {
        return $this->state(fn (array $attributes) => [
            'media_type' => 'audio',
            'duration' => fake()->numberBetween(10, 300),
            'thumbnail_path' => null
        ]);
    }

    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => fake()->numberBetween(10000000, 100000000) // 10-100MB
        ]);
    }
}

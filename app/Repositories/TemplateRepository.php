<?php

namespace App\Repositories;

use App\Models\Template;
use App\Repositories\Interfaces\TemplateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class TemplateRepository implements TemplateRepositoryInterface
{
    public function getAllTemplates(): Collection
    {
        return Template::with(['creator', 'greetings'])->get();
    }

    public function getTemplateById(int $id): ?Template
    {
        try {
            return Template::with(['creator', 'greetings'])->find($id);
        } catch (\Exception $e) {
            Log::error("Error finding Template by ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function createTemplate(array $data): Template
    {
        return Template::create($data);
    }

    public function updateTemplate(int $id, array $data): bool
    {
        try {
            $template = Template::findOrFail($id);
            return $template->update($data);
        } catch (\Exception $e) {
            Log::error("Error updating Template ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTemplate(int $id): bool
    {
        try {
            $template = Template::findOrFail($id);
            return $template->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting Template ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    // Additional specific methods
    public function getTemplatesByCategory(string $category): Collection
    {
        return Template::with(['creator'])
            ->where('category', $category)
            ->orderBy('usage_count', 'desc')
            ->get();
    }

    public function getPremiumTemplates(): Collection
    {
        return Template::with(['creator'])
            ->where('is_premium', true)
            ->orderBy('rating', 'desc')
            ->get();
    }

    public function getFreeTemplates(): Collection
    {
        return Template::with(['creator'])
            ->where('is_premium', false)
            ->orderBy('usage_count', 'desc')
            ->get();
    }

    public function getPopularTemplates(int $limit = 10): Collection
    {
        return Template::with(['creator'])
            ->orderBy('usage_count', 'desc')
            ->orderBy('rating', 'desc')
            ->limit($limit)
            ->get();
    }
}
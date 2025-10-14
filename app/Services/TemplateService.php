<?php

namespace App\Services;

use App\Models\Template;
use App\Repositories\Interfaces\TemplateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TemplateService
{
    public function __construct(
        private TemplateRepositoryInterface $templateRepository
    ) {}

    public function createTemplate(int $creatorId, array $data): Template
    {
        $data['creator_id'] = $creatorId;
        $data['usage_count'] = 0;
        $data['rating'] = 0;

        return $this->templateRepository->createTemplate($data);
    }

    public function getRecommendedTemplates(int $userId, string $occasion = null): array
    {
        // Get user's previous template usage
        $popularTemplates = $this->templateRepository->getPopularTemplates(10);
        
        if ($occasion) {
            $categoryTemplates = $this->templateRepository->getTemplatesByCategory($occasion);
            return $categoryTemplates->toArray();
        }

        return $popularTemplates->toArray();
    }

    public function canAccessTemplate(int $userId, Template $template): bool
    {
        // Free templates are accessible to everyone
        if (!$template->is_premium) {
            return true;
        }

        // Premium templates require verified creator status
        $user = \App\Models\User::find($userId);
        return $user && $user->is_verified_creator;
    }

    public function trackTemplateUsage(Template $template): void
    {
        $template->incrementUsage();
    }

    public function getTemplatesByCategory(string $category, bool $premiumOnly = false): Collection
    {
        $query = $this->templateRepository->getAllTemplates()
            ->where('category', $category);
        
        if ($premiumOnly) {
            $query = $query->where('is_premium', true);
        }
        
        return $query->sortByDesc('usage_count');
    }

    public function getFreeTemplates(): Collection
    {
        return $this->templateRepository->getAllTemplates()
            ->where('is_premium', false)
            ->sortByDesc('usage_count');
    }

    public function searchTemplates(string $query, array $filters = []): Collection
    {
        $templates = $this->templateRepository->getAllTemplates();
        
        // Search by name and description
        $templates = $templates->filter(function ($template) use ($query) {
            return stripos($template->name, $query) !== false ||
                stripos($template->description, $query) !== false;
        });
        
        // Apply filters
        if (isset($filters['category'])) {
            $templates = $templates->where('category', $filters['category']);
        }
        
        if (isset($filters['is_premium'])) {
            $templates = $templates->where('is_premium', $filters['is_premium']);
        }
        
        return $templates->sortByDesc('usage_count');
    }

    public function getPopularTemplates(int $limit = 10): Collection
    {
        return $this->templateRepository->getAllTemplates()
            ->sortByDesc('usage_count')
            ->take($limit);
    }
}
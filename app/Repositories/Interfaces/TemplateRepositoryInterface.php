<?php

namespace App\Repositories\Interfaces;

use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;

interface TemplateRepositoryInterface
{
    public function getAllTemplates(): Collection;

    public function getTemplateById(int $id): ?Template;

    public function createTemplate(array $data): Template;

    public function updateTemplate(int $id, array $data): bool;

    public function deleteTemplate(int $id): bool;

    public function getTemplatesByCategory(string $category): Collection;

    public function getPremiumTemplates(): Collection;

    public function getFreeTemplates(): Collection;

    public function getPopularTemplates(int $limit = 10): Collection;
}

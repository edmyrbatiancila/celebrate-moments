<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating template library...');

            // Get some verified creators for custom templates
        $verifiedCreators = \App\Models\User::where('is_verified_creator', true)->get();
        
        // Create default system templates (free)
        $this->createDefaultTemplates();
        
        // Create premium templates
        $this->createPremiumTemplates();
        
        // Create creator-specific templates
        $this->createCreatorTemplates($verifiedCreators);
        
        $this->command->info('Template library created successfully!');
    }

    private function createDefaultTemplates(): void
    {
        $categories = ['birthday', 'anniversary', 'holiday', 'graduation', 'wedding'];
        
        foreach ($categories as $category) {
            // Create 2-3 free templates per category
            Template::factory(fake()->numberBetween(2, 3))
                ->free()
                ->create(['category' => $category]);
        }
    }

    private function createPremiumTemplates(): void
    {
        $categories = ['birthday', 'anniversary', 'holiday', 'graduation', 'wedding'];
        
        foreach ($categories as $category) {
            // Create 1-2 premium templates per category
            Template::factory(fake()->numberBetween(1, 2))
                ->premium()
                ->create(['category' => $category]);
        }
    }

    private function createCreatorTemplates($creators): void
    {
        foreach ($creators as $creator) {
            // Each verified creator gets 1-3 custom templates
            $templateCount = fake()->numberBetween(1, 3);
            
            \App\Models\Template::factory($templateCount)
                ->create([
                    'creator_id' => $creator->id,
                    'is_premium' => fake()->boolean(70) // 70% of creator templates are premium
                ]);
        }
    }
}

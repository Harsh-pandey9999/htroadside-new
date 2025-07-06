<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Roadside Tips',
            'Vehicle Maintenance',
            'Emergency Preparedness',
            'Travel Safety',
            'Industry News',
            'Customer Stories',
        ];

        foreach ($categories as $category) {
            // Check if category exists before creating it
            if (!BlogCategory::where('slug', Str::slug($category))->exists()) {
                BlogCategory::create([
                    'name' => $category,
                    'slug' => Str::slug($category),
                    'description' => 'Articles related to ' . strtolower($category),
                    'is_active' => true,
                ]);
            }
        }
    }
}

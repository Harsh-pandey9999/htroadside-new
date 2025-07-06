<?php

namespace Database\Seeders;

use App\Models\BlogTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Flat Tire',
            'Battery Issues',
            'Lockout',
            'Towing',
            'Jump Start',
            'Fuel Delivery',
            'Winter Tips',
            'Summer Driving',
            'DIY Fixes',
            'Emergency Kit',
            'Safety Tips',
            'Car Maintenance',
        ];

        foreach ($tags as $tag) {
            // Check if tag exists before creating it
            if (!BlogTag::where('slug', Str::slug($tag))->exists()) {
                BlogTag::create([
                    'name' => $tag,
                    'slug' => Str::slug($tag),
                    'is_active' => true,
                ]);
            }
        }
    }
}

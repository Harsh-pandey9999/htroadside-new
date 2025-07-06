<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'HT Roadside', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Your Reliable Partner on the Road', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => '24/7 roadside assistance services across India. Fast response, trained professionals, and affordable plans.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'logo', 'value' => 'logo-white.png', 'type' => 'file', 'group' => 'general'],
            ['key' => 'favicon', 'value' => 'favicon.ico', 'type' => 'file', 'group' => 'general'],
            
            // Contact Settings
            ['key' => 'contact_phone', 'value' => '+919415666567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@htroadside.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'address', 'value' => '123 Roadside Ave, City, State 12345', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'emergency_phone', 'value' => '+919415666567', 'type' => 'text', 'group' => 'contact'],
            
            // Social Media Settings
            ['key' => 'social_facebook', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => 'HT Roadside - 24/7 Roadside Assistance Services', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Get reliable 24/7 roadside assistance services across India. Fast response, trained professionals, and affordable plans.', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'roadside assistance, towing service, car breakdown, emergency service, vehicle recovery', 'type' => 'text', 'group' => 'seo'],
            
            // Footer Settings
            ['key' => 'footer_text', 'value' => '© ' . date('Y') . ' HT Roadside. All rights reserved.', 'type' => 'text', 'group' => 'footer'],
            ['key' => 'footer_description', 'value' => 'Your reliable partner on the road. We provide 24/7 roadside assistance services to keep you moving.', 'type' => 'text', 'group' => 'footer'],
            
            // Features Settings
            ['key' => 'enable_blog', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            ['key' => 'enable_testimonials', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            ['key' => 'enable_newsletter', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
} 
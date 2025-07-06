<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NewsletterSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Check if we already have subscriptions
        if (NewsletterSubscription::count() === 0) {
            // Create 10 sample newsletter subscriptions
            for ($i = 0; $i < 10; $i++) {
                NewsletterSubscription::create([
                    'email' => $faker->unique()->safeEmail(),
                    'name' => $faker->name(),
                    'is_active' => true,
                    'subscribed_at' => now()->subDays(rand(1, 30)),
                    'ip_address' => $faker->ipv4(),
                    'user_agent' => $faker->userAgent(),
                ]);
            }
            
            // Create a few unsubscribed users
            for ($i = 0; $i < 3; $i++) {
                NewsletterSubscription::create([
                    'email' => $faker->unique()->safeEmail(),
                    'name' => $faker->name(),
                    'is_active' => false,
                    'subscribed_at' => now()->subDays(rand(31, 60)),
                    'unsubscribed_at' => now()->subDays(rand(1, 30)),
                    'ip_address' => $faker->ipv4(),
                    'user_agent' => $faker->userAgent(),
                ]);
            }
        }
    }
}

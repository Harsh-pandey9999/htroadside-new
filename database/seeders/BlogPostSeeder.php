<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user or create one if none exists
        $user = \App\Models\User::first();
        
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }
        
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        
        $posts = [
            [
                'title' => 'What to Do When You Have a Flat Tire',
                'content' => '<p>Having a flat tire is one of the most common roadside emergencies. Here\'s what to do when it happens to you:</p>
                <h3>Step 1: Find a Safe Location</h3>
                <p>Pull over to a safe location away from traffic. If possible, find a flat, solid surface.</p>
                <h3>Step 2: Turn on Hazard Lights</h3>
                <p>Alert other drivers by turning on your hazard lights.</p>
                <h3>Step 3: Call for Help</h3>
                <p>If you\'re not comfortable changing the tire yourself or don\'t have the necessary equipment, call HT Roadside for professional assistance.</p>
                <h3>Step 4: Wait in a Safe Place</h3>
                <p>Stay in your vehicle with the doors locked while waiting for help to arrive.</p>',
                'category_id' => $categories->where('name', 'Roadside Tips')->first()->id,
                'tags' => $tags->whereIn('name', ['Flat Tire', 'Emergency Kit', 'Safety Tips'])->pluck('id')->toArray(),
            ],
            [
                'title' => 'Essential Items for Your Car Emergency Kit',
                'content' => '<p>Being prepared for roadside emergencies can make a significant difference in your safety and comfort. Here\'s what you should include in your car emergency kit:</p>
                <ul>
                <li>Jumper cables</li>
                <li>Flashlight with extra batteries</li>
                <li>First aid kit</li>
                <li>Basic tools (screwdrivers, pliers, adjustable wrench)</li>
                <li>Tire pressure gauge</li>
                <li>Spare tire and jack</li>
                <li>Reflective triangles or flares</li>
                <li>Blanket</li>
                <li>Non-perishable snacks and water</li>
                <li>Phone charger</li>
                </ul>
                <p>Having these items readily available can help you handle minor issues or stay comfortable while waiting for professional assistance.</p>',
                'category_id' => $categories->where('name', 'Emergency Preparedness')->first()->id,
                'tags' => $tags->whereIn('name', ['Emergency Kit', 'Safety Tips'])->pluck('id')->toArray(),
            ],
            [
                'title' => 'How to Prepare Your Vehicle for Winter Driving',
                'content' => '<p>Winter driving presents unique challenges that require special preparation. Follow these tips to ensure your vehicle is ready for winter conditions:</p>
                <h3>Check Your Battery</h3>
                <p>Cold weather puts additional strain on your battery. Have it tested before winter arrives to ensure it\'s in good condition.</p>
                <h3>Inspect Your Tires</h3>
                <p>Make sure your tires have adequate tread depth for winter driving. Consider switching to winter tires if you live in an area with heavy snowfall.</p>
                <h3>Test Your Heater and Defroster</h3>
                <p>Ensure your heating system is working properly to keep you warm and defrost your windows effectively.</p>
                <h3>Check Fluids</h3>
                <p>Use winter-grade oil and antifreeze. Also, keep your windshield washer fluid reservoir filled with a winter formula that won\'t freeze.</p>
                <h3>Pack a Winter Emergency Kit</h3>
                <p>In addition to your regular emergency kit, include items like a snow shovel, ice scraper, and extra warm clothing.</p>',
                'category_id' => $categories->where('name', 'Vehicle Maintenance')->first()->id,
                'tags' => $tags->whereIn('name', ['Winter Tips', 'Car Maintenance', 'Safety Tips'])->pluck('id')->toArray(),
            ],
            [
                'title' => 'What to Do When Your Car Won\'t Start',
                'content' => '<p>Few things are as frustrating as turning your key in the ignition and hearing nothing. Here\'s what to do when your car won\'t start:</p>
                <h3>Check the Battery</h3>
                <p>A dead battery is the most common reason for a car not starting. Look for signs like dim headlights or interior lights.</p>
                <h3>Try Jump-Starting</h3>
                <p>If you have jumper cables and access to another vehicle, you can try jump-starting your car.</p>
                <h3>Check the Fuel Level</h3>
                <p>It might sound obvious, but make sure you have fuel in your tank.</p>
                <h3>Listen for Unusual Sounds</h3>
                <p>If you hear clicking or grinding noises when trying to start your car, this can provide clues about what\'s wrong.</p>
                <h3>Call for Professional Help</h3>
                <p>If you can\'t identify or fix the problem, call HT Roadside for assistance. Our technicians can diagnose and often fix starting issues on the spot.</p>',
                'category_id' => $categories->where('name', 'Roadside Tips')->first()->id,
                'tags' => $tags->whereIn('name', ['Battery Issues', 'Jump Start', 'DIY Fixes'])->pluck('id')->toArray(),
            ],
            [
                'title' => 'How I Was Rescued During a Snowstorm',
                'content' => '<p>Last winter, I found myself stranded on a rural highway during an unexpected snowstorm. Here\'s my story and how HT Roadside came to my rescue.</p>
                <p>It was supposed to be a quick trip to visit my parents, just a two-hour drive that I\'d made countless times before. The weather forecast mentioned a chance of snow, but nothing serious. However, as anyone who lives in the Midwest knows, weather can change rapidly.</p>
                <p>About halfway through my journey, the light flurries turned into a full-blown snowstorm. Visibility dropped dramatically, and the roads quickly became covered in snow. I slowed down and tried to continue carefully, but then my car slid off the road and into a shallow ditch.</p>
                <p>I was stuck, with no way to get my car back on the road. Cell service was spotty, but I managed to call HT Roadside. Despite the challenging conditions, they assured me help was on the way.</p>
                <p>Within 45 minutes, a tow truck arrived. The driver, Mark, was professional and reassuring. He quickly assessed the situation, winched my car out of the ditch, and checked it for damage before sending me on my way.</p>
                <p>What could have been a dangerous situation turned into merely an inconvenience, thanks to the prompt and professional service from HT Roadside. I\'ve since recommended them to all my friends and family.</p>',
                'category_id' => $categories->where('name', 'Customer Stories')->first()->id,
                'tags' => $tags->whereIn('name', ['Winter Tips', 'Towing'])->pluck('id')->toArray(),
            ],
        ];
        
        foreach ($posts as $postData) {
            // Check if post exists before creating it
            $slug = Str::slug($postData['title']);
            $post = BlogPost::where('slug', $slug)->first();
            
            if (!$post) {
                $post = BlogPost::create([
                    'title' => $postData['title'],
                    'slug' => $slug,
                    'content' => $postData['content'],
                    'excerpt' => Str::limit(strip_tags($postData['content']), 150),
                    'user_id' => $user->id,
                    'category_id' => $postData['category_id'],
                    'status' => 'published',
                    'published_at' => now(),
                    'featured_image' => null,
                    'meta_title' => $postData['title'],
                    'meta_description' => Str::limit(strip_tags($postData['content']), 160),
                ]);
                
                // Attach tags
                $post->tags()->attach($postData['tags']);
            }
        }
    }
}

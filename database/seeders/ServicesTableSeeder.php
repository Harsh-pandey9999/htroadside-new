<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Towing Service',
                'slug' => 'towing-service',
                'short_description' => '24/7 professional towing service to get you back on the road quickly and safely.',
                'description' => 'Our 24/7 towing service is available to assist you whenever you need it. Whether you\'ve been in an accident, your car has broken down, or you simply need a tow to the nearest repair shop, our professional team is here to help. We offer quick response times and safe transportation for your vehicle to your desired location.',
                'icon' => 'local_shipping',
                'is_active' => true,
                'price' => 75.00,
                'estimated_time' => '30-60 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'towing', '24/7']),
                'featured' => true,
                'service_area' => 'All areas',
            ],
            [
                'name' => 'Battery Jump Start',
                'slug' => 'battery-jump-start',
                'short_description' => 'Fast and reliable battery jump start service to get your car running again.',
                'description' => 'A dead battery can happen to anyone, but our quick and reliable battery jump start service will get you back on the road in no time. Our technicians are equipped with the necessary tools to safely jump start your vehicle. If your battery is beyond repair, we can also help with battery replacement services.',
                'icon' => 'battery_charging_full',
                'is_active' => true,
                'price' => 35.00,
                'estimated_time' => '15-30 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'battery', 'jump start']),
                'featured' => true,
                'service_area' => 'All areas',
            ],
            [
                'name' => 'Flat Tire Change',
                'slug' => 'flat-tire-change',
                'short_description' => 'Professional tire changing service when you have a flat or damaged tire.',
                'description' => 'Don\'t let a flat tire ruin your day. Our professional tire changing service will have you back on the road quickly and safely. We can replace your flat tire with your spare or help you get to the nearest tire shop for a permanent fix. Our technicians are trained to handle all types of vehicles and tire situations.',
                'icon' => 'settings',
                'is_active' => true,
                'price' => 45.00,
                'estimated_time' => '20-40 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'tire', 'flat tire']),
                'featured' => true,
                'service_area' => 'All areas',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@htroadside.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'is_service_provider' => false,
            'address' => '123 Admin Street',
            'city' => 'Admin City',
            'state' => 'AS',
            'postal_code' => '12345',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // Create service provider user
        $provider = User::create([
            'name' => 'Service Provider',
            'email' => 'provider@htroadside.com',
            'password' => Hash::make('provider123'),
            'email_verified_at' => now(),
            'is_service_provider' => true,
            'address' => '456 Provider Road',
            'city' => 'Provider City',
            'state' => 'PS',
            'postal_code' => '23456',
            'is_verified' => true,
            'verified_at' => now(),
            'service_provider_type' => 'independent',
            'company_name' => 'Quick Roadside Assistance',
            'service_area' => 'Provider City and surrounding areas',
            'service_types' => json_encode(['towing', 'flat_tire', 'jump_start', 'fuel_delivery']),
            'rating' => 4.8,
            'total_ratings' => 25,
        ]);

        // Create customer user
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@htroadside.com',
            'password' => Hash::make('customer123'),
            'email_verified_at' => now(),
            'is_service_provider' => false,
            'address' => '789 Customer Avenue',
            'city' => 'Customer City',
            'state' => 'CS',
            'postal_code' => '34567',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // Assign roles if the Role model exists
        try {
            if (class_exists('App\\Models\\Role')) {
                $adminRole = Role::where('name', 'admin')->first();
                $providerRole = Role::where('name', 'service_provider')->first();
                $customerRole = Role::where('name', 'customer')->first();
                
                if ($adminRole) {
                    $admin->roles()->attach($adminRole->id);
                }
                
                if ($providerRole) {
                    $provider->roles()->attach($providerRole->id);
                }
                
                if ($customerRole) {
                    $customer->roles()->attach($customerRole->id);
                }
            }
        } catch (\Exception $e) {
            // Role relationship might not exist, continue without error
        }
    }
}

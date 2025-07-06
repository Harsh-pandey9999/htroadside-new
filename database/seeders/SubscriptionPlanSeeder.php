<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'description' => 'Essential roadside assistance coverage for occasional drivers.',
                'price' => 9.99,
                'billing_cycle' => 'monthly',
                'features' => [
                    'Up to 3 service calls per year',
                    'Towing up to 5 miles',
                    'Flat tire assistance',
                    'Battery jump-start',
                    'Lockout service',
                    'Fuel delivery (cost of fuel not included)',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Standard Plan',
                'description' => 'Comprehensive coverage for regular drivers with enhanced benefits.',
                'price' => 19.99,
                'billing_cycle' => 'monthly',
                'features' => [
                    'Up to 5 service calls per year',
                    'Towing up to 25 miles',
                    'Flat tire assistance',
                    'Battery jump-start and replacement',
                    'Lockout service',
                    'Fuel delivery (includes cost of fuel)',
                    'Winching service',
                    'Trip interruption benefits',
                    '24/7 priority service',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium Plan',
                'description' => 'Ultimate roadside assistance package with unlimited service calls and maximum coverage.',
                'price' => 29.99,
                'billing_cycle' => 'monthly',
                'features' => [
                    'Unlimited service calls',
                    'Towing up to 100 miles',
                    'Flat tire assistance and replacement',
                    'Battery jump-start and replacement',
                    'Lockout service with key replacement',
                    'Fuel delivery (includes cost of fuel)',
                    'Winching service',
                    'Trip interruption benefits',
                    'Rental car reimbursement',
                    'Hotel discounts',
                    '24/7 VIP priority service',
                    'Family coverage (up to 5 members)',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Annual Basic',
                'description' => 'Save with our annual basic plan for occasional drivers.',
                'price' => 99.99,
                'billing_cycle' => 'yearly',
                'features' => [
                    'Up to 3 service calls per year',
                    'Towing up to 5 miles',
                    'Flat tire assistance',
                    'Battery jump-start',
                    'Lockout service',
                    'Fuel delivery (cost of fuel not included)',
                    '15% savings compared to monthly billing',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Annual Standard',
                'description' => 'Our most popular annual plan with great value for regular drivers.',
                'price' => 199.99,
                'billing_cycle' => 'yearly',
                'features' => [
                    'Up to 5 service calls per year',
                    'Towing up to 25 miles',
                    'Flat tire assistance',
                    'Battery jump-start and replacement',
                    'Lockout service',
                    'Fuel delivery (includes cost of fuel)',
                    'Winching service',
                    'Trip interruption benefits',
                    '24/7 priority service',
                    '15% savings compared to monthly billing',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Annual Premium',
                'description' => 'Ultimate annual roadside assistance package with maximum coverage and best value.',
                'price' => 299.99,
                'billing_cycle' => 'yearly',
                'features' => [
                    'Unlimited service calls',
                    'Towing up to 100 miles',
                    'Flat tire assistance and replacement',
                    'Battery jump-start and replacement',
                    'Lockout service with key replacement',
                    'Fuel delivery (includes cost of fuel)',
                    'Winching service',
                    'Trip interruption benefits',
                    'Rental car reimbursement',
                    'Hotel discounts',
                    '24/7 VIP priority service',
                    'Family coverage (up to 5 members)',
                    '15% savings compared to monthly billing',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}

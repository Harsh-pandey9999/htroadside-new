<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Plan;
use App\Services\DatabaseSettingsService;

class PlansController extends Controller
{
    /**
     * Display a listing of the plans.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Try to get plans from database first
            $plans = Plan::where('is_active', true)->get();
            
            if ($plans->isEmpty()) {
                // If no plans in database, use mock data
                $plans = $this->getMockPlans();
            }
        } catch (QueryException $e) {
            // If database access fails, use mock data instead
            \Log::error('Error fetching plans: ' . $e->getMessage());
            $plans = $this->getMockPlans();
            
            // Flash a message about using default data
            session()->flash('warning', 'Using default plan data due to database connection issues.');
        }
        
        return view('pages.plans', compact('plans'));
    }
    
    /**
     * Display the specified plan.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            // Try to get the plan from database first
            $plan = Plan::where('id', $id)->orWhere('slug', $id)->where('is_active', true)->first();
            
            if (!$plan) {
                // If not found in database, try mock data
                $mockPlans = $this->getMockPlans();
                $plan = collect($mockPlans)->first(function ($item) use ($id) {
                    return $item['id'] == $id || $item['slug'] == $id;
                });
                
                if (!$plan) {
                    abort(404, 'Plan not found');
                }
                
                // Convert to object if from mock data
                $plan = (object) $plan;
            }
        } catch (QueryException $e) {
            // If database access fails, use mock data
            \Log::error('Error fetching plan details: ' . $e->getMessage());
            $mockPlans = $this->getMockPlans();
            $plan = collect($mockPlans)->first(function ($item) use ($id) {
                return $item['id'] == $id || $item['slug'] == $id;
            });
            
            if (!$plan) {
                abort(404, 'Plan not found');
            }
            
            // Convert to object
            $plan = (object) $plan;
            
            // Flash a message about using default data
            session()->flash('warning', 'Using default plan data due to database connection issues.');
        }
        
        return view('pages.plan-detail', compact('plan'));
    }
    
    /**
     * Get mock plans data for fallback when database is unavailable
     *
     * @return array
     */
    private function getMockPlans()
    {
        $plans = [
            [
                'id' => 1,
                'name' => 'Basic Plan',
                'slug' => 'basic-plan',
                'description' => 'Essential roadside assistance coverage for individual drivers.',
                'price' => 9.99,
                'interval' => 'month',
                'features' => [
                    'Towing up to 5 miles',
                    'Jump start service',
                    'Flat tire change',
                    'Lockout assistance',
                    'Fuel delivery (cost of fuel extra)',
                    '24/7 phone support',
                ],
                'is_popular' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Premium Plan',
                'slug' => 'premium-plan',
                'description' => 'Comprehensive coverage with extended benefits for regular drivers.',
                'price' => 19.99,
                'interval' => 'month',
                'features' => [
                    'Towing up to 25 miles',
                    'Jump start service',
                    'Flat tire change',
                    'Lockout assistance',
                    'Fuel delivery (includes cost of fuel)',
                    'Winching service',
                    'Trip interruption benefits',
                    '24/7 phone and app support',
                    'Up to 4 service calls per year',
                ],
                'is_popular' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Family Plan',
                'slug' => 'family-plan',
                'description' => 'Complete protection for families with multiple vehicles and drivers.',
                'price' => 29.99,
                'interval' => 'month',
                'features' => [
                    'Towing up to 100 miles',
                    'Jump start service',
                    'Flat tire change',
                    'Lockout assistance',
                    'Fuel delivery (includes cost of fuel)',
                    'Winching service',
                    'Trip interruption benefits',
                    'Rental car reimbursement',
                    'Coverage for up to 5 family members',
                    '24/7 priority phone and app support',
                    'Unlimited service calls per year',
                ],
                'is_popular' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        return collect($plans)->map(function ($plan) {
            // Convert features array to a format that can be used in views
            if (isset($plan['features']) && is_array($plan['features'])) {
                $plan['features_list'] = $plan['features'];
                $plan['features'] = json_encode($plan['features']);
            }
            return $plan;
        })->all();
    }
}

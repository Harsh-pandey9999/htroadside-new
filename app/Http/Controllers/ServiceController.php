<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Database\QueryException;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::where('is_active', true)->paginate(12);
            return view('pages.services-material', compact('services'));
        } catch (\Exception $e) {
            \Log::error('Error fetching services: ' . $e->getMessage());
            // Create mock services with pagination for fallback
            $mockServices = collect($this->getMockServices(12))->map(function ($item) {
                return (object) $item;
            });
            
            $services = new \Illuminate\Pagination\LengthAwarePaginator(
                $mockServices, 
                count($mockServices), 
                12, 
                1, 
                ['path' => request()->url()]
            );
            
            return view('pages.services-material', compact('services'))->with('warning', 'Using default service data due to database connection issues.');
        }
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/services'), $imageName);
            $data['image'] = 'images/services/'.$imageName;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully');
    }

    public function show($slug)
    {
        try {
            $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
            return view('pages.service-detail-material', compact('service'));
        } catch (\Exception $e) {
            \Log::error('Error fetching service details: ' . $e->getMessage());
            // Create a mock service for fallback
            $mockServices = $this->getMockServices();
            $service = null;
            
            // Find the mock service with matching slug
            foreach ($mockServices as $mockService) {
                if ($mockService['slug'] === $slug) {
                    $service = (object) $mockService;
                    break;
                }
            }
            
            if (!$service) {
                abort(404, 'Service not found');
            }
            
            return view('pages.service-detail-material', compact('service'))->with('warning', 'Using default service data due to database connection issues.');
        }
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug,'.$service->id,
            'short_description' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }
            
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/services'), $imageName);
            $data['image'] = 'images/services/'.$imageName;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        // Delete image file
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }
        
        $service->delete();
        
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully');
    }
    
    /**
     * Get mock services data for fallback when database is unavailable
     * 
     * @param int $count Number of services to return
     * @return array
     */
    protected function getMockServices($count = null)
    {
        $services = [
            [
                'id' => 1,
                'name' => 'Towing Service',
                'slug' => 'towing-service',
                'short_description' => '24/7 professional towing service to get you back on the road quickly and safely.',
                'description' => 'Our 24/7 towing service is available to assist you whenever you need it. Whether you\'ve been in an accident, your car has broken down, or you simply need a tow to the nearest repair shop, our professional team is here to help. We offer quick response times and safe transportation for your vehicle to your desired location.',
                'icon' => 'local_shipping',
                'image' => 'images/services/towing.jpg',
                'is_active' => true,
                'price' => 75.00,
                'estimated_time' => '30-60 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'towing', '24/7']),
                'featured' => true,
                'service_area' => 'All areas',
                'created_at' => '2023-01-01',
                'updated_at' => '2023-01-01'
            ],
            [
                'id' => 2,
                'name' => 'Battery Jump Start',
                'slug' => 'battery-jump-start',
                'short_description' => 'Fast and reliable battery jump start service to get your car running again.',
                'description' => 'A dead battery can happen to anyone, but our quick and reliable battery jump start service will get you back on the road in no time. Our technicians are equipped with the necessary tools to safely jump start your vehicle. If your battery is beyond repair, we can also help with battery replacement services.',
                'icon' => 'battery_charging_full',
                'image' => 'images/services/battery.jpg',
                'is_active' => true,
                'price' => 35.00,
                'estimated_time' => '15-30 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'battery', 'jump start']),
                'featured' => true,
                'service_area' => 'All areas',
                'created_at' => '2023-01-02',
                'updated_at' => '2023-01-02'
            ],
            [
                'id' => 3,
                'name' => 'Flat Tire Change',
                'slug' => 'flat-tire-change',
                'short_description' => 'Professional tire changing service when you have a flat or damaged tire.',
                'description' => 'Don\'t let a flat tire ruin your day. Our professional tire changing service will have you back on the road quickly and safely. We can replace your flat tire with your spare or help you get to the nearest tire shop for a permanent fix. Our technicians are trained to handle all types of vehicles and tire situations.',
                'icon' => 'settings',
                'image' => 'images/services/tire-change.jpg',
                'is_active' => true,
                'price' => 45.00,
                'estimated_time' => '20-40 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'tire', 'flat tire']),
                'featured' => true,
                'service_area' => 'All areas',
                'created_at' => '2023-01-03',
                'updated_at' => '2023-01-03'
            ],
            [
                'id' => 4,
                'name' => 'Lockout Service',
                'slug' => 'lockout-service',
                'short_description' => 'Professional help when you\'re locked out of your vehicle.',
                'description' => 'Locked your keys in your car? Our professional lockout service can help you get back into your vehicle quickly and safely. We use specialized tools and techniques to unlock your car without causing damage to the lock or door. Available 24/7 for your convenience.',
                'icon' => 'lock_open',
                'image' => 'images/services/lockout.jpg',
                'is_active' => true,
                'price' => 50.00,
                'estimated_time' => '15-30 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'lockout', 'keys']),
                'featured' => true,
                'service_area' => 'All areas',
                'created_at' => '2023-01-04',
                'updated_at' => '2023-01-04'
            ],
            [
                'id' => 5,
                'name' => 'Fuel Delivery',
                'slug' => 'fuel-delivery',
                'short_description' => 'Emergency fuel when you run out on the road.',
                'description' => 'Run out of gas? We\'ll deliver enough fuel to get you to the nearest gas station. Our service is available 24/7 for your convenience.',
                'icon' => 'local_gas_station',
                'image' => 'images/services/fuel-delivery.jpg',
                'is_active' => true,
                'price' => 40.00,
                'estimated_time' => '30-45 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'fuel', 'gas']),
                'featured' => true,
                'service_area' => 'All areas',
                'created_at' => '2023-01-05',
                'updated_at' => '2023-01-05'
            ],
            [
                'id' => 6,
                'name' => 'Lockout Assistance',
                'slug' => 'lockout-assistance',
                'short_description' => 'Professional help when you\'re locked out of your vehicle.',
                'description' => 'Locked your keys in your car? Our technicians use specialized tools to safely unlock your vehicle without causing damage.',
                'icon' => 'vpn_key',
                'image' => 'images/services/lockout.jpg',
                'is_active' => true,
                'price' => 50.00,
                'estimated_time' => '15-30 mins',
                'category' => 'Emergency',
                'tags' => json_encode(['emergency', 'lockout', 'keys']),
                'featured' => true,
                'service_area' => 'All areas',
                'created_at' => '2023-01-06',
                'updated_at' => '2023-01-06'
            ],
        ];
        
        if ($count !== null) {
            return array_slice($services, 0, $count);
        }
        
        return $services;
    }
}

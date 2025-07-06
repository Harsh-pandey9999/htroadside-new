<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Services\DatabaseSettingsService;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Try to get services from database first
            $services = Service::where('is_active', true)->take(6)->get();
        } catch (\Exception $e) {
            // If database access fails, use mock data instead
            // Convert array items to objects to match the expected structure in views
            $servicesArray = $this->getMockServices(6);
            $services = collect($servicesArray)->map(function ($item) {
                return (object) $item;
            });
        }
        
        // Always use the Material theme
        return view('pages.home-material', compact('services'));
    }

    public function services()
    {
        try {
            // Try to get services from database first
            $services = Service::where('is_active', true)->paginate(12);
        } catch (\Exception $e) {
            // If database access fails, use mock data instead
            // Convert array items to objects and paginate
            $servicesArray = $this->getMockServices(12);
            $services = collect($servicesArray)->map(function ($item) {
                return (object) $item;
            })->paginate(12);
        }
        
        // Always use the Material theme
        return view('pages.services-material', compact('services'));
    }

    public function serviceDetail($slug)
    {
        try {
            // Try to get the service from database first
            $service = Service::where('slug', $slug)->where('is_active', true)->first();
            
            if (!$service) {
                // If not found in database, try mock data
                $allServices = $this->getMockServices(20);
                $serviceArray = collect($allServices)->firstWhere('slug', $slug);
                
                if (!$serviceArray) {
                    abort(404);
                }
                
                // Convert to object
                $service = (object) $serviceArray;
            }
        } catch (\Exception $e) {
            // If database access fails, use mock data
            $allServices = $this->getMockServices(20);
            $serviceArray = collect($allServices)->firstWhere('slug', $slug);
            
            if (!$serviceArray) {
                abort(404);
            }
            
            // Convert to object
            $service = (object) $serviceArray;
        }
        
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('pages.service-detail-material', compact('service'));
        } else {
            return view('pages.service-detail', compact('service'));
        }
    }

    public function about()
    {
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('pages.about-material');
        } else {
            return view('pages.about');
        }
    }

    public function contact()
    {
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('pages.contact-material');
        } else {
            return view('pages.contact');
        }
    }

    public function submitContact(Request $request)
{
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);
        
        // Get admin email from settings using the DatabaseSettingsService
        $settingsService = app(DatabaseSettingsService::class);
        $adminEmail = $settingsService->get('admin_email', config('mail.from.address'));
        
        // Send email to admin
        \Mail::send('emails.contact', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message
        ], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                   ->subject('New Contact Form Submission');
        });
        
        return redirect()->back()->with('success', 'Thank you for contacting us. We will get back to you soon!');
    }

    public function plans()
    {
        // Using mock data for plans
        $plans = $this->getMockPlans();
        
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('pages.plans-material', compact('plans'));
        } else {
            return view('pages.plans', compact('plans'));
        }
    }
    
    /**
     * Get mock services data
     *
     * @param int $count
     * @return array
     */
    private function getMockServices($count = 6)
    {
        $allServices = [
            [
                'id' => 1,
                'title' => 'Emergency Roadside Assistance',
                'slug' => 'emergency-roadside-assistance',
                'description' => 'Immediate help when you need it most. Our emergency roadside assistance service is available 24/7 to get you back on the road quickly and safely.',
                'content' => '<p>Our Emergency Roadside Assistance service provides immediate help when you need it most. Available 24/7, our team of professionals is ready to assist you with any roadside emergency.</p><p>Services include:</p><ul><li>Flat tire changes</li><li>Jump starts</li><li>Fuel delivery</li><li>Lockout assistance</li><li>Winching</li></ul><p>We pride ourselves on fast response times and professional service, ensuring you get back on the road quickly and safely.</p>',
                'featured_image' => 'assets/images/services/emergency-assistance.jpg',
                'icon' => 'fas fa-ambulance',
                'price' => 75.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Towing Services',
                'slug' => 'towing-services',
                'description' => 'Professional towing services for all vehicle types. Whether you need a short-distance tow or long-distance transport, our fleet is equipped to handle your needs.',
                'content' => '<p>Our professional towing services are designed to safely transport your vehicle wherever it needs to go. We have a fleet of modern tow trucks equipped to handle vehicles of all sizes.</p><p>Our towing services include:</p><ul><li>Local towing</li><li>Long-distance towing</li><li>Flatbed towing</li><li>Motorcycle towing</li><li>Heavy-duty towing</li></ul><p>All our drivers are certified professionals who prioritize the safety of your vehicle during transport.</p>',
                'featured_image' => 'assets/images/services/towing.jpg',
                'icon' => 'fas fa-truck-pickup',
                'price' => 95.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Battery Jump Start',
                'slug' => 'battery-jump-start',
                'description' => 'Quick and reliable battery jump start service. Our technicians will get your vehicle running again and can perform a battery health check on the spot.',
                'content' => '<p>Our Battery Jump Start service provides a quick solution when your vehicle won\'t start due to a dead battery. Our technicians arrive promptly with professional equipment to safely jump-start your vehicle.</p><p>The service includes:</p><ul><li>Professional jump start</li><li>Battery health assessment</li><li>Alternator check</li><li>Advice on battery maintenance</li></ul><p>If your battery needs replacement, we can provide that service on the spot or recommend the best options for your vehicle.</p>',
                'featured_image' => 'assets/images/services/battery-jump.jpg',
                'icon' => 'fas fa-car-battery',
                'price' => 65.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Flat Tire Change',
                'slug' => 'flat-tire-change',
                'description' => 'Fast and efficient flat tire change service. We will replace your flat tire with your spare and ensure you are ready to continue your journey safely.',
                'content' => '<p>Our Flat Tire Change service provides quick assistance when you experience a flat tire on the road. Our skilled technicians will replace your flat tire with your spare tire efficiently and safely.</p><p>The service includes:</p><ul><li>Tire removal and replacement</li><li>Proper torquing of lug nuts</li><li>Inspection of the spare tire</li><li>Advice on tire maintenance</li></ul><p>If you don\'t have a spare tire or if it\'s not in good condition, we can arrange for towing to the nearest tire shop.</p>',
                'featured_image' => 'assets/images/services/flat-tire.jpg',
                'icon' => 'fas fa-cog',
                'price' => 55.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'title' => 'Fuel Delivery',
                'slug' => 'fuel-delivery',
                'description' => 'Run out of fuel? We will deliver gasoline or diesel directly to your location, allowing you to reach the nearest gas station safely.',
                'content' => '<p>Our Fuel Delivery service provides a convenient solution when you run out of fuel on the road. We deliver gasoline or diesel fuel directly to your location, allowing you to continue your journey to the nearest gas station.</p><p>The service includes:</p><ul><li>Delivery of up to 5 gallons of fuel</li><li>Choice of regular, premium gasoline, or diesel</li><li>Quick response times</li><li>Service available 24/7</li></ul><p>The fuel cost is included in the service fee, so there are no additional charges to worry about.</p>',
                'featured_image' => 'assets/images/services/fuel-delivery.jpg',
                'icon' => 'fas fa-gas-pump',
                'price' => 70.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'title' => 'Lockout Assistance',
                'slug' => 'lockout-assistance',
                'description' => 'Locked your keys in your car? Our lockout specialists use professional tools and techniques to safely unlock your vehicle without causing damage.',
                'content' => '<p>Our Lockout Assistance service provides professional help when you\'ve locked your keys inside your vehicle. Our trained technicians use specialized tools to safely unlock your car without causing any damage.</p><p>The service includes:</p><ul><li>Non-destructive entry techniques</li><li>Professional tools and equipment</li><li>Quick response times</li><li>Service for all vehicle makes and models</li></ul><p>Our technicians are trained to handle various locking systems, ensuring your vehicle is accessed safely and securely.</p>',
                'featured_image' => 'assets/images/services/lockout.jpg',
                'icon' => 'fas fa-key',
                'price' => 65.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'title' => 'Winching Service',
                'slug' => 'winching-service',
                'description' => 'Stuck in mud, snow, or a ditch? Our winching service can safely recover your vehicle and get you back on the road quickly.',
                'content' => '<p>Our Winching Service provides professional assistance when your vehicle is stuck in mud, snow, sand, or a ditch. Our experienced operators use powerful winches and proper techniques to safely recover your vehicle without causing damage.</p><p>The service includes:</p><ul><li>Assessment of the situation</li><li>Safe recovery planning</li><li>Professional winching equipment</li><li>Experienced operators</li></ul><p>We can handle various situations and vehicle types, from cars stuck in snow to SUVs in mud or off-road scenarios.</p>',
                'featured_image' => 'assets/images/services/winching.jpg',
                'icon' => 'fas fa-truck-monster',
                'price' => 120.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'title' => 'Mobile Tire Repair',
                'slug' => 'mobile-tire-repair',
                'description' => 'On-the-spot tire repair service. Our mobile technicians can patch or plug your tire at your location, saving you a trip to the tire shop.',
                'content' => '<p>Our Mobile Tire Repair service brings professional tire repair directly to your location. Instead of towing your vehicle to a tire shop, our technicians can repair many common tire issues on the spot.</p><p>The service includes:</p><ul><li>Tire puncture assessment</li><li>Professional patching or plugging</li><li>Tire inflation to proper pressure</li><li>Tire rotation if needed</li></ul><p>This service is ideal for repairable punctures in the tread area. If the tire damage is too severe for roadside repair, we can arrange towing to a tire shop.</p>',
                'featured_image' => 'assets/images/services/tire-repair.jpg',
                'icon' => 'fas fa-tools',
                'price' => 85.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Convert to collection and take the requested number of items
        return collect($allServices)->take($count)->all();
    }
    
    /**
     * Get mock plans data
     *
     * @return array
     */
    private function getMockPlans()
    {
        return [
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
    }
    
    public function workWithUs()
    {
        $teamMembers = [
            [
                'name' => 'Walter White',
                'position' => 'CEO',
                'image' => 'assets/img/team/team-1.jpg'
            ],
            [
                'name' => 'Sarah Jhonson',
                'position' => 'Product Manager',
                'image' => 'assets/img/team/team-2.jpg'
            ],
            [
                'name' => 'William Anderson',
                'position' => 'CTO',
                'image' => 'assets/img/team/team-3.jpg'
            ],
            [
                'name' => 'Amanda Jepson',
                'position' => 'Accountant',
                'image' => 'assets/img/team/team-4.jpg'
            ]
        ];
        
        return view('pages.work-with-us', compact('teamMembers'));
    }
    
    /**
     * Display the terms of service page
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        try {
            $designVersion = session('design_version', 'original');
            if ($designVersion === 'material') {
                return view('pages.terms-material');
            } else {
                return view('pages.terms');
            }
        } catch (\Exception $e) {
            \Log::error('Error loading terms page: ' . $e->getMessage());
            return view('pages.error')->with('message', 'Unable to load the Terms of Service page. Please try again later.');
        }
    }
    
    /**
     * Display the privacy policy page
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        try {
            $designVersion = session('design_version', 'original');
            if ($designVersion === 'material') {
                return view('pages.privacy-material');
            } else {
                return view('pages.privacy');
            }
        } catch (\Exception $e) {
            \Log::error('Error loading privacy page: ' . $e->getMessage());
            return view('pages.error')->with('message', 'Unable to load the Privacy Policy page. Please try again later.');
        }
    }
    
    /**
     * Display the cookie policy page
     *
     * @return \Illuminate\View\View
     */
    public function cookies()
    {
        try {
            $designVersion = session('design_version', 'original');
            if ($designVersion === 'material') {
                return view('pages.cookies-material');
            } else {
                return view('pages.cookies');
            }
        } catch (\Exception $e) {
            \Log::error('Error loading cookies page: ' . $e->getMessage());
            return view('pages.error')->with('message', 'Unable to load the Cookie Policy page. Please try again later.');
        }
    }
}

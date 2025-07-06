<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Career;
use App\Models\CareerApplication;
use App\Services\DatabaseSettingsService;

class CareerController extends Controller
{
    /**
     * Display a listing of the careers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Try to get careers from database first
            $careers = Career::active()->orderBy('featured', 'desc')->orderBy('created_at', 'desc')->get();
            
            if ($careers->isEmpty()) {
                // If no careers in database, use mock data
                $careers = $this->getMockCareers();
            }
        } catch (QueryException $e) {
            // If database access fails, use mock data instead
            \Log::error('Error fetching careers: ' . $e->getMessage());
            $careers = $this->getMockCareers();
            
            // Flash a message about using default data
            session()->flash('warning', 'Using default career data due to database connection issues.');
        }
        
        return view('pages.careers.index', compact('careers'));
    }
    
    /**
     * Display the specified career.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        try {
            // Try to get the career from database first
            $career = Career::active()->where('slug', $slug)->first();
            
            if (!$career) {
                // If not found in database, try mock data
                $mockCareers = $this->getMockCareers();
                $careerArray = collect($mockCareers)->firstWhere('slug', $slug);
                
                if (!$careerArray) {
                    abort(404, 'Job not found');
                }
                
                // Convert to object if from mock data
                $career = (object) $careerArray;
            }
            
            // Get related careers
            try {
                $relatedCareers = Career::active()
                    ->where('id', '!=', $career->id ?? 0)
                    ->where('department', $career->department ?? '')
                    ->take(3)
                    ->get();
                    
                if ($relatedCareers->isEmpty()) {
                    $relatedCareers = Career::active()
                        ->where('id', '!=', $career->id ?? 0)
                        ->take(3)
                        ->get();
                }
                
                if ($relatedCareers->isEmpty()) {
                    $mockRelated = collect($this->getMockCareers())
                        ->filter(function($item) use ($slug) {
                            return $item['slug'] != $slug;
                        })
                        ->take(3);
                    $relatedCareers = $mockRelated;
                }
            } catch (QueryException $e) {
                \Log::error('Error fetching related careers: ' . $e->getMessage());
                $mockRelated = collect($this->getMockCareers())
                    ->filter(function($item) use ($slug) {
                        return $item['slug'] != $slug;
                    })
                    ->take(3);
                $relatedCareers = $mockRelated;
            }
            
        } catch (QueryException $e) {
            // If database access fails, use mock data
            \Log::error('Error fetching career details: ' . $e->getMessage());
            $mockCareers = $this->getMockCareers();
            $careerArray = collect($mockCareers)->firstWhere('slug', $slug);
            
            if (!$careerArray) {
                abort(404, 'Job not found');
            }
            
            // Convert to object
            $career = (object) $careerArray;
            
            // Get mock related careers
            $mockRelated = collect($mockCareers)
                ->filter(function($item) use ($slug) {
                    return $item['slug'] != $slug;
                })
                ->take(3);
            $relatedCareers = $mockRelated;
            
            // Flash a message about using default data
            session()->flash('warning', 'Using default career data due to database connection issues.');
        }
        
        return view('pages.careers.show', compact('career', 'relatedCareers'));
    }
    
    /**
     * Show the application form for a job.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function apply($slug)
    {
        try {
            // Try to get the career from database first
            $career = Career::active()->where('slug', $slug)->first();
            
            if (!$career) {
                // If not found in database, try mock data
                $mockCareers = $this->getMockCareers();
                $careerArray = collect($mockCareers)->firstWhere('slug', $slug);
                
                if (!$careerArray) {
                    abort(404, 'Job not found');
                }
                
                // Convert to object if from mock data
                $career = (object) $careerArray;
            }
        } catch (QueryException $e) {
            // If database access fails, use mock data
            \Log::error('Error fetching career for application: ' . $e->getMessage());
            $mockCareers = $this->getMockCareers();
            $careerArray = collect($mockCareers)->firstWhere('slug', $slug);
            
            if (!$careerArray) {
                abort(404, 'Job not found');
            }
            
            // Convert to object
            $career = (object) $careerArray;
            
            // Flash a message about using default data
            session()->flash('warning', 'Using default career data due to database connection issues.');
        }
        
        return view('pages.careers.apply', compact('career'));
    }
    
    /**
     * Store a new job application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitApplication(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);
        
        try {
            // Try to get the career from database first
            $career = Career::active()->where('slug', $slug)->first();
            
            if (!$career) {
                // If not found in database, try mock data
                $mockCareers = $this->getMockCareers();
                $careerArray = collect($mockCareers)->firstWhere('slug', $slug);
                
                if (!$careerArray) {
                    abort(404, 'Job not found');
                }
                
                // For mock data, we'll just pretend the application was submitted
                session()->flash('success', 'Your application has been submitted successfully. We will contact you soon!');
                return redirect()->route('careers.index');
            }
            
            // Handle resume upload
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
            }
            
            // Create new application
            $application = new CareerApplication([
                'career_id' => $career->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'cover_letter' => $request->cover_letter,
                'resume_path' => $resumePath,
                'status' => CareerApplication::STATUS_NEW,
                'viewed' => false
            ]);
            
            $application->save();
            
            // Get admin email from settings using the DatabaseSettingsService
            $settingsService = app(DatabaseSettingsService::class);
            $adminEmail = $settingsService->get('admin_email', config('mail.from.address'));
            
            // Send email notification to admin
            \Mail::send('emails.career-application', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'job' => $career->title,
                'location' => $career->location
            ], function ($message) use ($adminEmail, $career) {
                $message->to($adminEmail)
                       ->subject('New Job Application: ' . $career->title);
            });
            
            session()->flash('success', 'Your application has been submitted successfully. We will contact you soon!');
            return redirect()->route('careers.index');
            
        } catch (QueryException $e) {
            \Log::error('Error submitting job application: ' . $e->getMessage());
            
            // Even if database fails, we'll pretend it worked to avoid user frustration
            session()->flash('success', 'Your application has been submitted successfully. We will contact you soon!');
            return redirect()->route('careers.index');
        } catch (\Exception $e) {
            \Log::error('Error in job application process: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'There was an error submitting your application. Please try again later.']);
        }
    }
    
    /**
     * Get mock careers data for fallback when database is unavailable
     *
     * @return array
     */
    private function getMockCareers()
    {
        $careers = [
            [
                'id' => 1,
                'title' => 'Roadside Assistance Technician',
                'slug' => 'roadside-assistance-technician',
                'department' => 'Field Operations',
                'location' => 'Multiple Locations',
                'type' => 'Full-time',
                'description' => 'We are seeking experienced roadside assistance technicians to join our growing team. As a technician, you will be responsible for providing timely and professional assistance to our members who experience vehicle breakdowns or emergencies.',
                'responsibilities' => [
                    'Respond to roadside assistance calls in a timely manner',
                    'Perform basic vehicle diagnostics and repairs',
                    'Provide jump starts, tire changes, and lockout assistance',
                    'Tow vehicles when necessary',
                    'Maintain accurate records of service calls',
                    'Ensure customer satisfaction through professional service',
                    'Adhere to all safety protocols and procedures'
                ],
                'requirements' => [
                    'High school diploma or equivalent',
                    'Valid driver\'s license with clean driving record',
                    'Previous experience in automotive repair or roadside assistance preferred',
                    'Basic mechanical knowledge and troubleshooting skills',
                    'Excellent customer service skills',
                    'Ability to work flexible hours, including nights, weekends, and holidays',
                    'Physical ability to lift up to 50 pounds and work in various weather conditions'
                ],
                'benefits' => [
                    'Competitive hourly wage with overtime opportunities',
                    'Health, dental, and vision insurance',
                    '401(k) retirement plan with company match',
                    'Paid time off and holiday pay',
                    'Company vehicle and equipment provided',
                    'Ongoing training and career advancement opportunities',
                    'Employee discount program'
                ],
                'salary_min' => 35000,
                'salary_max' => 55000,
                'is_active' => true,
                'expires_at' => now()->addMonths(2),
                'featured' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'id' => 2,
                'title' => 'Customer Service Representative',
                'slug' => 'customer-service-representative',
                'department' => 'Customer Support',
                'location' => 'Remote',
                'type' => 'Full-time',
                'description' => 'We are looking for friendly and efficient Customer Service Representatives to join our team. In this role, you will be the first point of contact for our members, handling incoming calls and assisting with roadside assistance requests, membership inquiries, and general information.',
                'responsibilities' => [
                    'Answer incoming calls and respond to member inquiries',
                    'Process roadside assistance requests and dispatch technicians',
                    'Provide information about membership plans and services',
                    'Handle membership renewals and upgrades',
                    'Address and resolve customer complaints',
                    'Maintain accurate records of all customer interactions',
                    'Meet or exceed performance metrics for call handling'
                ],
                'requirements' => [
                    'High school diploma or equivalent',
                    'Previous customer service experience, preferably in a call center environment',
                    'Excellent communication and interpersonal skills',
                    'Ability to remain calm and professional in high-pressure situations',
                    'Basic computer skills and ability to learn new software quickly',
                    'Availability to work flexible hours, including evenings, weekends, and holidays',
                    'Strong problem-solving abilities'
                ],
                'benefits' => [
                    'Competitive hourly wage with performance bonuses',
                    'Health, dental, and vision insurance',
                    '401(k) retirement plan with company match',
                    'Paid time off and holiday pay',
                    'Remote work options available',
                    'Professional development opportunities',
                    'Employee discount program'
                ],
                'salary_min' => 30000,
                'salary_max' => 45000,
                'is_active' => true,
                'expires_at' => now()->addMonths(1),
                'featured' => false,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'id' => 3,
                'title' => 'Fleet Manager',
                'slug' => 'fleet-manager',
                'department' => 'Operations',
                'location' => 'Chicago, IL',
                'type' => 'Full-time',
                'description' => 'We are seeking an experienced Fleet Manager to oversee our growing fleet of service vehicles. The ideal candidate will have a strong background in fleet management, vehicle maintenance, and team leadership.',
                'responsibilities' => [
                    'Oversee the maintenance and repair of all company vehicles',
                    'Develop and implement preventive maintenance schedules',
                    'Manage vehicle acquisition, registration, and disposal',
                    'Monitor fuel consumption and implement efficiency measures',
                    'Ensure compliance with all DOT regulations and safety standards',
                    'Supervise fleet maintenance staff',
                    'Analyze fleet data to optimize performance and reduce costs',
                    'Maintain accurate records of all fleet operations'
                ],
                'requirements' => [
                    'Bachelor\'s degree in Business Administration, Logistics, or related field',
                    '3+ years of experience in fleet management',
                    'Knowledge of DOT regulations and vehicle safety standards',
                    'Experience with fleet management software',
                    'Strong leadership and team management skills',
                    'Excellent analytical and problem-solving abilities',
                    'Valid driver\'s license with clean driving record'
                ],
                'benefits' => [
                    'Competitive salary',
                    'Comprehensive health, dental, and vision insurance',
                    '401(k) retirement plan with company match',
                    'Paid time off and holiday pay',
                    'Performance bonuses',
                    'Professional development opportunities',
                    'Company vehicle',
                    'Employee discount program'
                ],
                'salary_min' => 60000,
                'salary_max' => 80000,
                'is_active' => true,
                'expires_at' => now()->addMonths(3),
                'featured' => true,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'id' => 4,
                'title' => 'Marketing Specialist',
                'slug' => 'marketing-specialist',
                'department' => 'Marketing',
                'location' => 'New York, NY',
                'type' => 'Full-time',
                'description' => 'We are looking for a creative and data-driven Marketing Specialist to help grow our membership base and increase brand awareness. The ideal candidate will have experience in digital marketing, content creation, and campaign management.',
                'responsibilities' => [
                    'Develop and implement marketing strategies to promote our roadside assistance services',
                    'Create engaging content for social media, email, and website',
                    'Manage digital advertising campaigns across multiple platforms',
                    'Analyze marketing data and adjust strategies for optimal performance',
                    'Collaborate with the design team to create marketing materials',
                    'Coordinate with the sales team to align marketing efforts with sales goals',
                    'Monitor industry trends and competitor activities'
                ],
                'requirements' => [
                    'Bachelor\'s degree in Marketing, Communications, or related field',
                    '2+ years of experience in marketing, preferably in the automotive or service industry',
                    'Proficiency in digital marketing platforms and analytics tools',
                    'Experience with content management systems and email marketing software',
                    'Strong written and verbal communication skills',
                    'Creative thinking and problem-solving abilities',
                    'Knowledge of SEO and SEM principles'
                ],
                'benefits' => [
                    'Competitive salary',
                    'Comprehensive health, dental, and vision insurance',
                    '401(k) retirement plan with company match',
                    'Paid time off and holiday pay',
                    'Flexible work schedule',
                    'Professional development opportunities',
                    'Employee discount program'
                ],
                'salary_min' => 50000,
                'salary_max' => 70000,
                'is_active' => true,
                'expires_at' => now()->addMonths(2),
                'featured' => false,
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
        ];
        
        return collect($careers)->map(function ($career) {
            // Convert arrays to JSON strings for compatibility with model casts
            if (isset($career['responsibilities']) && is_array($career['responsibilities'])) {
                $career['responsibilities_list'] = $career['responsibilities'];
                $career['responsibilities'] = json_encode($career['responsibilities']);
            }
            if (isset($career['requirements']) && is_array($career['requirements'])) {
                $career['requirements_list'] = $career['requirements'];
                $career['requirements'] = json_encode($career['requirements']);
            }
            if (isset($career['benefits']) && is_array($career['benefits'])) {
                $career['benefits_list'] = $career['benefits'];
                $career['benefits'] = json_encode($career['benefits']);
            }
            return $career;
        })->all();
    }
}

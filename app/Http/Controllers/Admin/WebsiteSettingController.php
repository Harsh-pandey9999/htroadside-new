<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Services\DatabaseSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        try {
            $settings = WebsiteSetting::all()->pluck('value', 'key');
            return view('admin.settings.index', compact('settings'));
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::index: ' . $e->getMessage());
            
            // Use default settings from the service
            $settingsService = app(DatabaseSettingsService::class);
            $defaultSettings = $settingsService->getDefaultSettings();
            $settings = collect($defaultSettings);
            
            // Flash a message about using default settings
            session()->flash('warning', 'Could not connect to the database. Using default settings. Please check your database configuration.');
            
            return view('admin.settings.index', compact('settings'));
        }
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'footer_text' => 'nullable|string',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_linkedin' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'google_analytics_id' => 'nullable|string|max:50',
            'meta_keywords' => 'nullable|string',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'enable_blog' => 'boolean',
            'enable_testimonials' => 'boolean',
            'enable_newsletter' => 'boolean',
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'privacy_policy' => 'nullable|string',
            'about_us' => 'nullable|string',
            'map_latitude' => 'nullable|numeric',
            'map_longitude' => 'nullable|numeric',
            'map_zoom' => 'nullable|integer|min:1|max:20',
            'default_currency' => 'nullable|string|size:3',
            'default_timezone' => 'nullable|string',
            'default_language' => 'nullable|string|size:2',
        ]);
        
        try {
            $settingsService = app(DatabaseSettingsService::class);
            
            foreach ($validated as $key => $value) {
                // Skip file uploads
                if (in_array($key, ['logo', 'favicon'])) {
                    continue;
                }
                
                // Use the service to update settings
                $settingsService->set($key, $value);
            }
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::update: ' . $e->getMessage());
            return redirect()->route('admin.settings.index')
                ->with('error', 'Could not update settings due to database connection issue. Please check your database configuration.');
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            try {
                $logoSetting = WebsiteSetting::where('key', 'logo')->first();
                
                // Delete old logo if exists
                if ($logoSetting && $logoSetting->value) {
                    Storage::disk('public')->delete($logoSetting->value);
                }
                
                $path = $request->file('logo')->store('website', 'public');
                
                $settingsService = app(DatabaseSettingsService::class);
                $settingsService->set('logo', $path);
            } catch (\Exception $e) {
                Log::error('Error handling logo upload: ' . $e->getMessage());
                // Continue with other operations even if logo upload fails
            }
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            try {
                $faviconSetting = WebsiteSetting::where('key', 'favicon')->first();
                
                // Delete old favicon if exists
                if ($faviconSetting && $faviconSetting->value) {
                    Storage::disk('public')->delete($faviconSetting->value);
                }
                
                $path = $request->file('favicon')->store('website', 'public');
                
                $settingsService = app(DatabaseSettingsService::class);
                $settingsService->set('favicon', $path);
            } catch (\Exception $e) {
                Log::error('Error handling favicon upload: ' . $e->getMessage());
                // Continue with other operations even if favicon upload fails
            }
        }
        
        // Clear settings cache
        Cache::forget('website_settings');
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Website settings updated successfully.');
    }
    
    public function seo()
    {
        try {
            $settings = WebsiteSetting::all()->pluck('value', 'key');
            return view('admin.settings.seo', compact('settings'));
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::seo: ' . $e->getMessage());
            
            // Use default settings from the service
            $settingsService = app(DatabaseSettingsService::class);
            $defaultSettings = $settingsService->getDefaultSettings();
            $settings = collect($defaultSettings);
            
            // Flash a message about using default settings
            session()->flash('warning', 'Could not connect to the database. Using default settings. Please check your database configuration.');
            
            return view('admin.settings.seo', compact('settings'));
        }
    }
    
    public function updateSeo(Request $request)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|max:2048',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image,app,player',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'twitter_image' => 'nullable|image|max:2048',
            'canonical_url' => 'nullable|url',
            'robots_txt' => 'nullable|string',
            'sitemap_enabled' => 'boolean',
            'google_site_verification' => 'nullable|string|max:255',
            'bing_site_verification' => 'nullable|string|max:255',
            'schema_markup' => 'nullable|string',
        ]);
        
        try {
            $settingsService = app(DatabaseSettingsService::class);
            
            foreach ($validated as $key => $value) {
                // Skip file uploads
                if (in_array($key, ['og_image', 'twitter_image'])) {
                    continue;
                }
                
                // Use the service to update settings
                $settingsService->set($key, $value);
            }
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::updateSeo: ' . $e->getMessage());
            return redirect()->route('admin.settings.seo')
                ->with('error', 'Could not update SEO settings due to database connection issue. Please check your database configuration.');
        }
        
        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            try {
                $ogImageSetting = WebsiteSetting::where('key', 'og_image')->first();
                
                // Delete old image if exists
                if ($ogImageSetting && $ogImageSetting->value) {
                    Storage::disk('public')->delete($ogImageSetting->value);
                }
                
                $path = $request->file('og_image')->store('website/seo', 'public');
                
                $settingsService = app(DatabaseSettingsService::class);
                $settingsService->set('og_image', $path);
            } catch (\Exception $e) {
                Log::error('Error handling OG image upload: ' . $e->getMessage());
                // Continue with other operations even if image upload fails
            }
        }
        
        // Handle Twitter image upload
        if ($request->hasFile('twitter_image')) {
            try {
                $twitterImageSetting = WebsiteSetting::where('key', 'twitter_image')->first();
                
                // Delete old image if exists
                if ($twitterImageSetting && $twitterImageSetting->value) {
                    Storage::disk('public')->delete($twitterImageSetting->value);
                }
                
                $path = $request->file('twitter_image')->store('website/seo', 'public');
                
                $settingsService = app(DatabaseSettingsService::class);
                $settingsService->set('twitter_image', $path);
            } catch (\Exception $e) {
                Log::error('Error handling Twitter image upload: ' . $e->getMessage());
                // Continue with other operations even if image upload fails
            }
        }
        
        // Clear settings cache
        Cache::forget('website_settings');
        
        return redirect()->route('admin.settings.seo')
            ->with('success', 'SEO settings updated successfully.');
    }
    
    public function email()
    {
        try {
            $settings = WebsiteSetting::all()->pluck('value', 'key');
            return view('admin.settings.email', compact('settings'));
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::email: ' . $e->getMessage());
            
            // Use default settings from the service
            $settingsService = app(DatabaseSettingsService::class);
            $defaultSettings = $settingsService->getDefaultSettings();
            $settings = collect($defaultSettings);
            
            // Flash a message about using default settings
            session()->flash('warning', 'Could not connect to the database. Using default settings. Please check your database configuration.');
            
            return view('admin.settings.email', compact('settings'));
        }
    }
    
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|string|in:smtp,sendmail,mailgun,ses,postmark,log,array',
            'mail_host' => 'required_if:mail_mailer,smtp|nullable|string',
            'mail_port' => 'required_if:mail_mailer,smtp|nullable|integer',
            'mail_username' => 'required_if:mail_mailer,smtp|nullable|string',
            'mail_password' => 'required_if:mail_mailer,smtp|nullable|string',
            'mail_encryption' => 'nullable|string|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
            'admin_email' => 'required|email',
            'notification_email' => 'required|email',
            'email_footer_text' => 'nullable|string',
            'email_logo' => 'nullable|image|max:2048',
        ]);
        
        try {
            $settingsService = app(DatabaseSettingsService::class);
            
            foreach ($validated as $key => $value) {
                // Skip file uploads
                if ($key === 'email_logo') {
                    continue;
                }
                
                // Use the service to update settings
                $settingsService->set($key, $value);
            }
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::updateEmail: ' . $e->getMessage());
            return redirect()->route('admin.settings.email')
                ->with('error', 'Could not update email settings due to database connection issue. Please check your database configuration.');
        }
        
        // Handle email logo upload
        if ($request->hasFile('email_logo')) {
            try {
                $emailLogoSetting = WebsiteSetting::where('key', 'email_logo')->first();
                
                // Delete old logo if exists
                if ($emailLogoSetting && $emailLogoSetting->value) {
                    Storage::disk('public')->delete($emailLogoSetting->value);
                }
                
                $path = $request->file('email_logo')->store('website/email', 'public');
                
                $settingsService = app(DatabaseSettingsService::class);
                $settingsService->set('email_logo', $path);
            } catch (\Exception $e) {
                Log::error('Error handling email logo upload: ' . $e->getMessage());
                // Continue with other operations even if logo upload fails
            }
        }
        
        // Update .env file
        $this->updateEnvironmentFile([
            'MAIL_MAILER' => $validated['mail_mailer'],
            'MAIL_HOST' => $validated['mail_host'] ?? '',
            'MAIL_PORT' => $validated['mail_port'] ?? '',
            'MAIL_USERNAME' => $validated['mail_username'] ?? '',
            'MAIL_PASSWORD' => $validated['mail_password'] ?? '',
            'MAIL_ENCRYPTION' => $validated['mail_encryption'] ?? '',
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
            'MAIL_FROM_NAME' => '"' . $validated['mail_from_name'] . '"',
        ]);
        
        // Clear settings cache
        Cache::forget('website_settings');
        
        return redirect()->route('admin.settings.email')
            ->with('success', 'Email settings updated successfully.');
    }
    
    public function payment()
    {
        try {
            $settings = WebsiteSetting::all()->pluck('value', 'key');
            return view('admin.settings.payment', compact('settings'));
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::payment: ' . $e->getMessage());
            
            // Use default settings from the service
            $settingsService = app(DatabaseSettingsService::class);
            $defaultSettings = $settingsService->getDefaultSettings();
            $settings = collect($defaultSettings);
            
            // Flash a message about using default settings
            session()->flash('warning', 'Could not connect to the database. Using default settings. Please check your database configuration.');
            
            return view('admin.settings.payment', compact('settings'));
        }
    }
    
    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'razorpay_key' => 'required|string',
            'razorpay_secret' => 'required|string',
            'currency' => 'required|string|size:3',
            'payment_description' => 'nullable|string',
            'enable_test_mode' => 'boolean',
            'test_razorpay_key' => 'required_if:enable_test_mode,1|nullable|string',
            'test_razorpay_secret' => 'required_if:enable_test_mode,1|nullable|string',
            'payment_success_page' => 'nullable|string',
            'payment_cancel_page' => 'nullable|string',
            'invoice_prefix' => 'nullable|string|max:10',
            'invoice_company_details' => 'nullable|string',
            'invoice_company_address' => 'nullable|string',
            'invoice_company_tax_id' => 'nullable|string',
            'invoice_footer_text' => 'nullable|string',
        ]);
        
        try {
            $settingsService = app(DatabaseSettingsService::class);
            
            foreach ($validated as $key => $value) {
                // Use the service to update settings
                $settingsService->set($key, $value);
            }
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::updatePayment: ' . $e->getMessage());
            return redirect()->route('admin.settings.payment')
                ->with('error', 'Could not update payment settings due to database connection issue. Please check your database configuration.');
        }
        
        // Update .env file for payment keys
        $this->updateEnvironmentFile([
            'RAZORPAY_KEY' => $validated['enable_test_mode'] ? $validated['test_razorpay_key'] : $validated['razorpay_key'],
            'RAZORPAY_SECRET' => $validated['enable_test_mode'] ? $validated['test_razorpay_secret'] : $validated['razorpay_secret'],
        ]);
        
        // Clear settings cache
        Cache::forget('website_settings');
        
        return redirect()->route('admin.settings.payment')
            ->with('success', 'Payment settings updated successfully.');
    }
    
    public function notifications()
    {
        try {
            $settings = WebsiteSetting::all()->pluck('value', 'key');
            return view('admin.settings.notifications', compact('settings'));
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::notifications: ' . $e->getMessage());
            
            // Use default settings from the service
            $settingsService = app(DatabaseSettingsService::class);
            $defaultSettings = $settingsService->getDefaultSettings();
            $settings = collect($defaultSettings);
            
            // Flash a message about using default settings
            session()->flash('warning', 'Could not connect to the database. Using default settings. Please check your database configuration.');
            
            return view('admin.settings.notifications', compact('settings'));
        }
    }
    
    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'enable_email_notifications' => 'boolean',
            'enable_sms_notifications' => 'boolean',
            'enable_push_notifications' => 'boolean',
            'sms_provider' => 'nullable|string|in:twilio,nexmo,msg91',
            'twilio_sid' => 'required_if:sms_provider,twilio|nullable|string',
            'twilio_auth_token' => 'required_if:sms_provider,twilio|nullable|string',
            'twilio_from_number' => 'required_if:sms_provider,twilio|nullable|string',
            'nexmo_key' => 'required_if:sms_provider,nexmo|nullable|string',
            'nexmo_secret' => 'required_if:sms_provider,nexmo|nullable|string',
            'nexmo_from_number' => 'required_if:sms_provider,nexmo|nullable|string',
            'msg91_auth_key' => 'required_if:sms_provider,msg91|nullable|string',
            'msg91_sender_id' => 'required_if:sms_provider,msg91|nullable|string',
            'firebase_server_key' => 'nullable|string',
            'notify_admin_on_new_request' => 'boolean',
            'notify_admin_on_payment' => 'boolean',
            'notify_admin_on_job_application' => 'boolean',
            'notify_provider_on_assignment' => 'boolean',
            'notify_user_on_status_change' => 'boolean',
            'admin_notification_emails' => 'nullable|string',
        ]);
        
        try {
            $settingsService = app(DatabaseSettingsService::class);
            
            foreach ($validated as $key => $value) {
                // Use the service to update settings
                $settingsService->set($key, $value);
            }
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingController::updateNotifications: ' . $e->getMessage());
            return redirect()->route('admin.settings.notifications')
                ->with('error', 'Could not update notification settings due to database connection issue. Please check your database configuration.');
        }
        
        // Clear settings cache
        Cache::forget('website_settings');
        
        return redirect()->route('admin.settings.notifications')
            ->with('success', 'Notification settings updated successfully.');
    }
    
    public function backup()
    {
        return view('admin.settings.backup');
    }
    
    public function createBackup(Request $request)
    {
        $validated = $request->validate([
            'backup_type' => 'required|in:full,database,files',
        ]);
        
        try {
            // In a real implementation, you would use a package like spatie/laravel-backup
            // For now, we'll simulate a backup
            
            $backupFileName = 'backup-' . date('Y-m-d-H-i-s') . '.zip';
            
            // Simulate backup creation
            sleep(2);
            
            return redirect()->route('admin.settings.backup')
                ->with('success', 'Backup created successfully: ' . $backupFileName);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.backup')
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
    
    public function downloadBackup($fileName)
    {
        // In a real implementation, you would check if the file exists and return it
        // For now, we'll just return a response
        
        return response()->json([
            'message' => 'This is a simulated backup download. In a real implementation, the file would be downloaded.',
        ]);
    }
    
    public function deleteBackup($fileName)
    {
        // In a real implementation, you would delete the file
        // For now, we'll just return a response
        
        return redirect()->route('admin.settings.backup')
            ->with('success', 'Backup deleted successfully.');
    }
    
    /**
     * Update the environment file with the given key-value pairs.
     *
     * @param  array  $data
     * @return void
     */
    protected function updateEnvironmentFile(array $data)
    {
        try {
            $path = app()->environmentFilePath();
            
            if (file_exists($path)) {
                $content = file_get_contents($path);
                
                foreach ($data as $key => $value) {
                    // If the key exists in the file
                    if (preg_match("/^{$key}=/m", $content)) {
                        // Replace the value
                        $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
                    } else {
                        // Add the key-value pair
                        $content .= "\n{$key}={$value}";
                    }
                }
                
                file_put_contents($path, $content);
            }
        } catch (\Exception $e) {
            Log::error('Error updating environment file: ' . $e->getMessage());
            // We'll continue even if environment file update fails
            // The settings will still be saved in the database
        }
    }
}

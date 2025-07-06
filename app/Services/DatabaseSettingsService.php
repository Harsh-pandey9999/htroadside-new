<?php

namespace App\Services;

use App\Models\WebsiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DatabaseSettingsService
{
    /**
     * Default settings to use when database is unavailable
     *
     * @var array
     */
    protected $defaultSettings = [
        // General settings
        'site_name' => 'HT Roadside Assistance',
        'site_title' => 'HT Roadside Assistance | 24/7 Emergency Services',
        'site_description' => 'Professional roadside assistance services available 24/7',
        'site_logo' => null,
        'site_favicon' => null,
        'admin_email' => 'admin@example.com',
        'contact_email' => 'contact@example.com',
        'contact_phone' => '+1234567890',
        'address' => '123 Main Street, City, Country',
        'footer_text' => ' 2023 HT Roadside Assistance. All rights reserved.',
        'social_facebook' => 'https://facebook.com',
        'social_twitter' => 'https://twitter.com',
        'social_instagram' => 'https://instagram.com',
        'social_linkedin' => 'https://linkedin.com',
        'google_analytics_id' => '',
        'recaptcha_site_key' => '',
        'recaptcha_secret_key' => '',
        'maintenance_mode' => '0',
        'maintenance_message' => 'We are currently performing maintenance. Please check back soon.',
        
        // SEO settings
        'meta_title' => 'HT Roadside Assistance | 24/7 Emergency Services',
        'meta_description' => 'Professional roadside assistance services available 24/7',
        'meta_keywords' => 'roadside assistance, towing, emergency, car service, breakdown',
        'og_title' => 'HT Roadside Assistance',
        'og_description' => 'Professional roadside assistance services available 24/7',
        'og_image' => null,
        'twitter_card' => 'summary_large_image',
        'twitter_title' => 'HT Roadside Assistance',
        'twitter_description' => 'Professional roadside assistance services available 24/7',
        'twitter_image' => null,
        'canonical_url' => '',
        'robots_txt' => 'User-agent: *\nDisallow: /admin/\nDisallow: /login\nDisallow: /register',
        'sitemap_enabled' => '1',
        'google_site_verification' => '',
        'bing_site_verification' => '',
        'schema_markup' => '',
        
        // Email settings
        'mail_mailer' => 'smtp',
        'mail_host' => 'smtp.mailtrap.io',
        'mail_port' => '2525',
        'mail_username' => '',
        'mail_password' => '',
        'mail_encryption' => 'tls',
        'mail_from_address' => 'noreply@example.com',
        'mail_from_name' => 'HT Roadside Assistance',
        'notification_email' => 'notifications@example.com',
        'email_footer_text' => 'Thank you for using our services.',
        'email_logo' => null,
        
        // Payment settings
        'razorpay_key' => '',
        'razorpay_secret' => '',
        'currency' => 'USD',
        'payment_description' => 'Payment for roadside assistance services',
        'enable_test_mode' => '1',
        'test_razorpay_key' => '',
        'test_razorpay_secret' => '',
        'payment_success_page' => '/payment/success',
        'payment_cancel_page' => '/payment/cancel',
        'invoice_prefix' => 'INV-',
        'invoice_company_details' => 'HT Roadside Assistance',
        'invoice_company_address' => '123 Main Street, City, Country',
        'invoice_company_tax_id' => '',
        'invoice_footer_text' => 'Thank you for your business.',
        
        // Notification settings
        'enable_email_notifications' => '1',
        'enable_sms_notifications' => '0',
        'enable_push_notifications' => '0',
        'sms_provider' => 'twilio',
        'twilio_sid' => '',
        'twilio_auth_token' => '',
        'twilio_from_number' => '',
        'nexmo_key' => '',
        'nexmo_secret' => '',
        'nexmo_from_number' => '',
        'msg91_auth_key' => '',
        'msg91_sender_id' => '',
        'firebase_server_key' => '',
        'notify_admin_on_new_request' => '1',
        'notify_admin_on_payment' => '1',
        'notify_admin_on_job_application' => '1',
        'notify_provider_on_assignment' => '1',
        'notify_user_on_status_change' => '1',
        'admin_notification_emails' => 'admin@example.com',
    ];

    /**
     * Get a setting value from the database or fallback to default
     * 
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        // Use the provided default or check our defaults array
        $fallbackDefault = $default ?? ($this->defaultSettings[$key] ?? null);
        
        try {
            return Cache::rememberForever('website_settings.' . $key, function () use ($key, $fallbackDefault) {
                try {
                    $setting = WebsiteSetting::where('key', $key)->first();
                    return $setting ? $setting->value : $fallbackDefault;
                } catch (QueryException $e) {
                    Log::error('Database error when fetching setting: ' . $key, ['error' => $e->getMessage()]);
                    return $fallbackDefault;
                }
            });
        } catch (\Exception $e) {
            Log::error('Error in settings service: ' . $e->getMessage());
            return $fallbackDefault;
        }
    }

    /**
     * Set a setting value in the database
     * 
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string $group
     * @return bool
     */
    public function set($key, $value, $type = 'text', $group = 'general')
    {
        try {
            $setting = WebsiteSetting::where('key', $key)->first();
            
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                WebsiteSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => $type,
                    'group' => $group
                ]);
            }
            
            // Clear the cache for this key
            Cache::forget('website_settings.' . $key);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error setting website setting: ' . $key, ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get all default settings
     * 
     * @return array
     */
    public function getDefaultSettings()
    {
        return $this->defaultSettings;
    }
}

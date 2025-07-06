<?php

namespace App\Services;

use App\Models\ApiSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS using Fast2SMS.
     *
     * @param string $phone
     * @param string $message
     * @param array $options
     * @return array
     */
    public function sendSms($phone, $message, $options = [])
    {
        try {
            $apiKey = ApiSetting::getSetting('fast2sms', 'api_key');
            $senderId = ApiSetting::getSetting('fast2sms', 'sender_id') ?? 'HTRDSDE';
            $route = ApiSetting::getSetting('fast2sms', 'route') ?? 'dlt';
            
            if (!$apiKey) {
                Log::error('Fast2SMS API key not found');
                return [
                    'success' => false,
                    'message' => 'SMS service is not configured properly'
                ];
            }
            
            // Clean the phone number (remove +91 or other prefixes if present)
            $phone = preg_replace('/[^0-9]/', '', $phone);
            
            // If the phone number starts with country code (e.g., 91 for India), remove it
            if (strlen($phone) > 10 && substr($phone, 0, 2) == '91') {
                $phone = substr($phone, 2);
            }
            
            // Prepare the request parameters
            $params = [
                'authorization' => $apiKey,
                'sender_id' => $senderId,
                'message' => $message,
                'route' => $route,
                'numbers' => $phone,
            ];
            
            // Add template_id if using DLT route
            if ($route === 'dlt' && isset($options['template_id'])) {
                $params['template_id'] = $options['template_id'];
            } elseif ($route === 'dlt') {
                $params['template_id'] = ApiSetting::getSetting('fast2sms', 'template_id');
            }
            
            // Add any additional parameters
            $params = array_merge($params, array_diff_key($options, array_flip(['template_id'])));
            
            // Make the API request
            $response = Http::withHeaders([
                'cache-control' => 'no-cache',
            ])->get('https://www.fast2sms.com/dev/bulkV2', $params);
            
            $result = $response->json();
            
            if (isset($result['return']) && $result['return'] === true) {
                Log::info('SMS sent successfully', [
                    'phone' => $phone,
                    'response' => $result
                ]);
                
                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'data' => $result
                ];
            } else {
                Log::error('Failed to send SMS', [
                    'phone' => $phone,
                    'response' => $result
                ]);
                
                return [
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to send SMS',
                    'data' => $result
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS: ' . $e->getMessage(), [
                'phone' => $phone,
                'exception' => $e
            ]);
            
            return [
                'success' => false,
                'message' => 'An error occurred while sending SMS: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Send an OTP via SMS.
     *
     * @param string $phone
     * @param string $otp
     * @return array
     */
    public function sendOtp($phone, $otp)
    {
        $templateId = ApiSetting::getSetting('fast2sms', 'template_id');
        
        // Default message format if no template is specified
        $message = "Your OTP for HT Roadside verification is: {$otp}. Valid for 10 minutes. Do not share this OTP with anyone.";
        
        return $this->sendSms($phone, $message, [
            'template_id' => $templateId,
            'variables' => json_encode(['#OTP#' => $otp]),
            'variables_values' => $otp
        ]);
    }
}

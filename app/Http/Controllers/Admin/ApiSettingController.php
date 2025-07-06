<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiSettingController extends Controller
{
    /**
     * Display a listing of the API settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $razorpaySettings = ApiSetting::where('provider', 'razorpay')->get();
        $fast2smsSettings = ApiSetting::where('provider', 'fast2sms')->get();

        return view('admin.api-settings.index', compact('razorpaySettings', 'fast2smsSettings'));
    }

    /**
     * Display the form for editing Razorpay settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function editRazorpay()
    {
        $settings = ApiSetting::where('provider', 'razorpay')->get();
        
        return view('admin.api-settings.edit-razorpay', compact('settings'));
    }

    /**
     * Update the Razorpay settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRazorpay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key_id' => 'required|string',
            'key_secret' => 'required|string',
            'webhook_secret' => 'nullable|string',
            'environment' => 'required|in:test,live',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update key_id
        $keyIdSetting = ApiSetting::where('provider', 'razorpay')
            ->where('key', 'key_id')
            ->first();
        
        if ($keyIdSetting) {
            $keyIdSetting->value = $request->key_id;
            $keyIdSetting->save();
        }

        // Update key_secret
        $keySecretSetting = ApiSetting::where('provider', 'razorpay')
            ->where('key', 'key_secret')
            ->first();
        
        if ($keySecretSetting) {
            $keySecretSetting->value = $request->key_secret;
            $keySecretSetting->save();
        }

        // Update webhook_secret
        $webhookSecretSetting = ApiSetting::where('provider', 'razorpay')
            ->where('key', 'webhook_secret')
            ->first();
        
        if ($webhookSecretSetting) {
            $webhookSecretSetting->value = $request->webhook_secret;
            $webhookSecretSetting->save();
        }

        // Update environment
        $environmentSetting = ApiSetting::where('provider', 'razorpay')
            ->where('key', 'environment')
            ->first();
        
        if ($environmentSetting) {
            $environmentSetting->value = $request->environment;
            $environmentSetting->save();
        }

        return redirect()->route('admin.api-settings.index')
            ->with('success', 'Razorpay settings updated successfully.');
    }

    /**
     * Display the form for editing Fast2SMS settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function editFast2sms()
    {
        $settings = ApiSetting::where('provider', 'fast2sms')->get();
        
        return view('admin.api-settings.edit-fast2sms', compact('settings'));
    }

    /**
     * Update the Fast2SMS settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFast2sms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|string',
            'sender_id' => 'required|string|max:6',
            'route' => 'required|in:dlt,quick',
            'template_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update api_key
        $apiKeySetting = ApiSetting::where('provider', 'fast2sms')
            ->where('key', 'api_key')
            ->first();
        
        if ($apiKeySetting) {
            $apiKeySetting->value = $request->api_key;
            $apiKeySetting->save();
        }

        // Update sender_id
        $senderIdSetting = ApiSetting::where('provider', 'fast2sms')
            ->where('key', 'sender_id')
            ->first();
        
        if ($senderIdSetting) {
            $senderIdSetting->value = $request->sender_id;
            $senderIdSetting->save();
        }

        // Update route
        $routeSetting = ApiSetting::where('provider', 'fast2sms')
            ->where('key', 'route')
            ->first();
        
        if ($routeSetting) {
            $routeSetting->value = $request->route;
            $routeSetting->save();
        }

        // Update template_id
        $templateIdSetting = ApiSetting::where('provider', 'fast2sms')
            ->where('key', 'template_id')
            ->first();
        
        if ($templateIdSetting) {
            $templateIdSetting->value = $request->template_id;
            $templateIdSetting->save();
        }

        return redirect()->route('admin.api-settings.index')
            ->with('success', 'Fast2SMS settings updated successfully.');
    }

    /**
     * Test the Razorpay API connection.
     *
     * @return \Illuminate\Http\Response
     */
    public function testRazorpay()
    {
        try {
            $keyId = ApiSetting::getSetting('razorpay', 'key_id');
            $keySecret = ApiSetting::getSetting('razorpay', 'key_secret');
            
            if (!$keyId || !$keySecret) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay API keys are not configured.'
                ]);
            }
            
            $api = new \Razorpay\Api\Api($keyId, $keySecret);
            $result = $api->customer->all();
            
            return response()->json([
                'success' => true,
                'message' => 'Razorpay API connection successful!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay API connection failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Test the Fast2SMS API connection.
     *
     * @return \Illuminate\Http\Response
     */
    public function testFast2sms()
    {
        try {
            $apiKey = ApiSetting::getSetting('fast2sms', 'api_key');
            
            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fast2SMS API key is not configured.'
                ]);
            }
            
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'authorization' => $apiKey,
                'cache-control' => 'no-cache',
            ])->get('https://www.fast2sms.com/dev/wallet');
            
            $result = $response->json();
            
            if (isset($result['wallet']) || isset($result['balance'])) {
                return response()->json([
                    'success' => true,
                    'message' => 'Fast2SMS API connection successful! Balance: ₹' . ($result['wallet'] ?? $result['balance'])
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Fast2SMS API connection failed: ' . ($result['message'] ?? 'Unknown error')
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fast2SMS API connection failed: ' . $e->getMessage()
            ]);
        }
    }
}

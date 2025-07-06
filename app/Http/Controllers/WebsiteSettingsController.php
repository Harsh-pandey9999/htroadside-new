<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use App\Services\DatabaseSettingsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class WebsiteSettingsController extends Controller
{
    public function index()
    {
        try {
            $generalSettings = WebsiteSetting::where('group', 'general')->get();
            $contactSettings = WebsiteSetting::where('group', 'contact')->get();
            $socialSettings = WebsiteSetting::where('group', 'social')->get();
            
            return view('admin.settings.index', compact('generalSettings', 'contactSettings', 'socialSettings'));
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingsController::index: ' . $e->getMessage());
            
            // Use default settings from the service
            $settingsService = app(DatabaseSettingsService::class);
            $defaultSettings = $settingsService->getDefaultSettings();
            
            // Create collections with default settings grouped by category
            $generalSettings = collect();
            $contactSettings = collect();
            $socialSettings = collect();
            
            foreach ($defaultSettings as $key => $value) {
                if (strpos($key, 'contact_') === 0) {
                    $contactSettings->push((object)['key' => $key, 'value' => $value, 'group' => 'contact']);
                } elseif (strpos($key, 'social_') === 0) {
                    $socialSettings->push((object)['key' => $key, 'value' => $value, 'group' => 'social']);
                } else {
                    $generalSettings->push((object)['key' => $key, 'value' => $value, 'group' => 'general']);
                }
            }
            
            // Flash a message about using default settings
            session()->flash('warning', 'Could not connect to the database. Using default settings. Please check your database configuration.');
            
            return view('admin.settings.index', compact('generalSettings', 'contactSettings', 'socialSettings'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:website_settings',
            'value' => 'required|string',
            'type' => 'required|string|in:text,boolean,number,file',
            'group' => 'required|string|max:255'
        ]);

        try {
            WebsiteSetting::create($request->all());
            return redirect()->back()->with('success', 'Setting created successfully');
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingsController::store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not create setting due to database connection issue. Please check your database configuration.');
        }
    }

    public function update(Request $request, WebsiteSetting $websiteSetting)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:website_settings,key,'.$websiteSetting->id,
            'value' => 'required|string',
            'type' => 'required|string|in:text,boolean,number,file',
            'group' => 'required|string|max:255'
        ]);

        try {
            $websiteSetting->update($request->all());
            
            // Also update the setting in our service to ensure cache is updated
            $settingsService = app(DatabaseSettingsService::class);
            $settingsService->set($request->key, $request->value, $request->type, $request->group);
            
            return redirect()->back()->with('success', 'Setting updated successfully');
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingsController::update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not update setting due to database connection issue. Please check your database configuration.');
        }
    }

    public function destroy(WebsiteSetting $websiteSetting)
    {
        try {
            $websiteSetting->delete();
            return redirect()->back()->with('success', 'Setting deleted successfully');
        } catch (QueryException $e) {
            Log::error('Database error in WebsiteSettingsController::destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not delete setting due to database connection issue. Please check your database configuration.');
        }
    }
}

<?php

use App\Services\DatabaseSettingsService;
use Illuminate\Support\Facades\App;

if (!function_exists('settings')) {
    /**
     * Get a website setting value.
     *
     * @param string $key The setting key
     * @param mixed $default The default value if setting is not found
     * @return mixed
     */
    function settings($key, $default = null)
    {
        // Use the DatabaseSettingsService to handle errors and provide fallbacks
        return App::make(DatabaseSettingsService::class)->get($key, $default);
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the DatabaseSettingsService
        $this->app->singleton(\App\Services\DatabaseSettingsService::class, function ($app) {
            return new \App\Services\DatabaseSettingsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default design version to material
        if (!session()->has('design_version')) {
            session(['design_version' => 'material']);
        }
        
        // Add database connection error handling
        $this->handleDatabaseConnection();
    }

    /**
     * Handle database connection errors and provide fallback mechanism
     */
    protected function handleDatabaseConnection(): void
    {
        try {
            // Test the database connection
            DB::connection()->getPdo();
        } catch (QueryException $e) {
            Log::error('Database connection failed: ' . $e->getMessage());
            
            // If the error contains 'Access denied', it's likely a credential issue
            if (str_contains($e->getMessage(), 'Access denied')) {
                // Log specific error about credentials
                Log::error('Database credentials issue detected. Please check your .env file for correct DB_USERNAME and DB_PASSWORD');
                
                // Display a more user-friendly error message if in debug mode
                if (config('app.debug')) {
                    echo '<div style="padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;">';
                    echo '<h3>Database Connection Error</h3>';
                    echo '<p>Could not connect to the database. Please check your database credentials in the .env file.</p>';
                    echo '<p>Common solutions:</p>';
                    echo '<ul>';
                    echo '<li>Verify DB_USERNAME and DB_PASSWORD in your .env file</li>';
                    echo '<li>Make sure the MySQL user has proper permissions</li>';
                    echo '<li>Check if MySQL server is running</li>';
                    echo '</ul>';
                    echo '</div>';
                }
            }
        }
    }
}

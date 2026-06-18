<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            try {
                $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
                view()->share('settings', $settings);
                view()->share('siteSettings', $settings);
            } catch (\Exception $e) {
                // Table might not exist yet before migrations run
            }
        }
    }
}

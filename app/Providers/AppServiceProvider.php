<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share global settings (contact info) across all views
        View::share('globalSettings', \App\Models\PageSection::getForPage('settings')['global'] ?? []);

        Schema::defaultStringLength(191);
    }
}
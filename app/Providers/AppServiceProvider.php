<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if (in_array(session('locale'), ['en', 'ar'], true)) {
            app()->setLocale(session('locale'));
        }
    }
}

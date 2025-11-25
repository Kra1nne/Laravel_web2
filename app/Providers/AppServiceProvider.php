<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(10),
                Limit::perMinute(3)->by($request->input('email_username')),
            ];
        });
        RateLimiter::for('api', function (Request $request) {
            return [
                Limit::perMinute(25)->by($request->ip()), // 60 requests per minute per IP
                Limit::perMinute(1000), // Global limit of 1000 requests per minute
            ];
        });

        // General web rate limiter
        RateLimiter::for('web', function (Request $request) {
            return [
                Limit::perMinute(25)->by($request->ip()), // 50 requests per minute per IP
                Limit::perMinute(2000), // Global limit of 2000 requests per minute
            ];
        });
    }
}

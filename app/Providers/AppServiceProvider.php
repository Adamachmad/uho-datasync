<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        // ===== FIX BUG #16: Configure rate limiting for file uploads =====
        RateLimiter::for('uploads', function (Request $request) {
            // Allow 10 uploads per 15 minutes per user
            return Limit::perMinutes(15, 10)
                ->by($request->input('id_pengaju') ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response('Terlalu banyak upload. Coba lagi dalam beberapa menit.', 429, $headers);
                });
        });
    }
}


<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        Log::info('RouteServiceProvider boot method started');

        RateLimiter::for('api', function (Request $request) {
            Log::info('Defining API rate limiter');
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Log::info('Registering API routes');
            $apiRouteFile = realpath(__DIR__ . '/../../routes/api.php');
            if (!$apiRouteFile) {
                Log::error('API route file not found');
                throw new \Exception('API route file not found');
            }
            Log::info('API route file path: ' . $apiRouteFile);
            Route::middleware('api')->prefix('api')->group($apiRouteFile);

            Log::info('Registering web routes');
            Route::middleware('web')->group(base_path('routes/web.php'));
        });

        Log::info('RouteServiceProvider boot method completed');
    }
}
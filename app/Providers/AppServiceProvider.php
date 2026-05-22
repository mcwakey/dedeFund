<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
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
        if (! app()->runningUnitTests() && str_contains((string) config('app.url'), '/index.php')) {
            URL::forceRootUrl(config('app.url'));
            Vite::createAssetPathsUsing(fn (string $path) => rtrim((string) config('app.url'), '/').'/'.ltrim($path, '/'));
        }
    }
}

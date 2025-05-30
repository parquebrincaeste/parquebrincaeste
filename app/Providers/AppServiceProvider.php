<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        JsonResource::withoutWrapping();
        Blade::directive('money', function ($money) {
            return "<?php echo '$ ' . number_format($money, 2); ?>";
        });

        Blade::directive('numberFormat', function ($number) {
            return "<?php echo number_format($number, 2); ?>";
        });

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}

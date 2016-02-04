<?php namespace App\Providers;

use App\Models\Locale;
use App\Observers\LocaleObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any necessary services.
     *
     * @return void
     */
    public function boot()
    {
        Locale::observe(new LocaleObserver());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}

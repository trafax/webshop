<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (app()->runningInConsole() == false) {

            Artisan::call('migrate');

            // De basis taal niet in de URL meenemen
            if (Language::where('default', 1)->first()) {
                Config::set('localized-routes.omit_url_prefix_for_locale', Language::where('default', 1)->first()->iso);
            }

            // Zet de beschikbare talen
            Config::set('localized-routes.supported-locales', Language::pluck('iso')->toArray());
        }
    }
}

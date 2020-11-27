<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

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
        //\URL::forceScheme('https');
    }
}

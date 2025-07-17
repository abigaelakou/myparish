<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

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
        //
        // DB::listen(function ($query) {
        //     Log::info("SQL Query: " . $query->sql);
        //     Log::info("Bindings: " . json_encode($query->bindings));
        // });
        if (env('APP_ENV') !== 'production') {
            // URL::forceScheme('https');
        }
    }


}
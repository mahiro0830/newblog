<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PostNumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        app()->bind('postNum', function() {
            
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

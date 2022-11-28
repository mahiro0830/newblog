<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Option;

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
        $options = Option::where('autoload', 'yes')->get();
        
    }
}

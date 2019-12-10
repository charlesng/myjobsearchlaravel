<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JobProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\BaseJobRepository', 'App\Repositories\ORMJobRepository');
        //
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

<?php

namespace Maven\CrudManager;

use Illuminate\Support\ServiceProvider;
use Maven\CrudManager\Console\Commands\CrudGenerator;

class CrudManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CrudGenerator::class,
            ]);
        }
    }


}

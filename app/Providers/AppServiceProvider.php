<?php

namespace App\Providers;

use Illuminate\View\View;
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
        view()->composer('*', function(View $view){
            $is_admin = false;
            if (auth()->user() !== null) {
                $is_admin = auth()->user()->is_admin;
            }
            $view->with('isAdmin', $is_admin);
        });
    }
}

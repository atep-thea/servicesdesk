<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     $social_medias = DB::table('socmeds')->get();
        
    //     View::composer('*', function($view) use ($social_medias) {
    //         $view->with('social_medias', $social_medias);
    //     });
    // }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class BladeExtrasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasrole',function($expresion){
            if(Auth::user()){
                if(Auth::user()->hasAnyRole($expresion)){
                    return true;
                }
            }
            return false;
        });
    }
}

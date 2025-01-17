<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\AliasLoader;
use Laravel\Sanctum\Sanctum;

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
    // public function boot()
    // {
    //     // Loader Alias
    //     $loader = AliasLoader::getInstance();

    //     // SANCTUM CUSTOM PERSONAL-ACCESS-TOKEN
    //     $loader->alias(\Laravel\Sanctum\PersonalAccessToken::class, PersonalAccessToken::class);
        
    // }
    

    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(\App\Models\Sanctum\PersonalAccessToken::class);
    }

}

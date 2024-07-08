<?php

namespace App\Providers;

use App\Models\PersonalAccessToken as ModelsPersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

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
        // Loader Alias
    // $loader = AliasLoader::getInstance();

    // SANCTUM CUSTOM PERSONAL-ACCESS-TOKEN
    // $loader->alias(\Laravel\Sanctum\PersonalAccessToken::class, PersonalAccessToken::class);
    }
}

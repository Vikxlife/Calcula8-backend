<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        class_alias(PersonalAccessToken::class, \Laravel\Sanctum\PersonalAccessToken::class);
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}

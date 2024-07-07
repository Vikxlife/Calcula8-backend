<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;


use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Relations\HasOne;
use Laravel\Sanctum\NewAccessToken;

class User extends EloquentModel implements AuthenticatableContract
{
    use SanctumHasApiTokens, Notifiable, HasFactory, AuthenticatableTrait, AuthorizableTrait;


    public function createCustomToken(string $name, array $abilities = ['*'])
    {
        // Custom logic before token creation
        $this->ensurePersonalAccessTokenExists();

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
        ]);

        // Custom logic after token creation

        return new NewAccessToken($token, $plainTextToken);
    }

    // protected function ensurePersonalAccessTokenExists()
    // {
    //     // Ensure the tokens relationship is correctly set up for MongoDB
    //     if (!class_exists(PersonalAccessToken::class)) {
    //         throw new \Exception("PersonalAccessToken class does not exist");
    //     }
    // }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function password_reset() : HasOne
    {
        return $this->hasOne(PasswordReset::class);
    }

    public function UserVerify(): HasOne 
    {
        return $this->hasOne(UserVerify::class);
    }

    public function UserProfile(): HasOne 
    {
        return $this->hasOne(UserProfile::class);
    }
    
}

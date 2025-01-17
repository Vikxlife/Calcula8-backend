<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
// use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne; 

class User extends EloquentModel implements AuthenticatableContract
{
    use HasApiTokens, Notifiable, HasFactory, AuthenticatableTrait, AuthorizableTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'username',
        'firstname',
        'lastname',
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

    public function ExamStatus(): HasMany
    {
        return $this->hasMany(ExamStatus::class);
    }

    public function ExamResults(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }
    
}

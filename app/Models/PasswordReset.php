<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Jenssegers\Mongodb\Relations\BelongsTo;


use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class PasswordReset extends EloquentModel
{
    use HasFactory;

    public $table = 'password_resets';

    protected $connection = 'mongodb';
    protected $collection = 'password_resets';

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'email',
        'token',
        'expiresAt',
    ];

    protected $casts = [
        'expiresAt' => 'datetime',
    ];




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

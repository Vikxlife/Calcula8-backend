<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class UserVerify extends EloquentModel
{
    use HasFactory;

    protected $table = 'users_verify';

    /**
     * Write code on Method
     *
     * @return response()
     */

     protected $connection = 'mongodb';
     protected $collection = 'users_verify';
 
    protected $fillable = [
        'user_id',
        'user_email',
        'token',
        'expiresAt',
    ];

    protected $casts = [
        'expiresAt' => 'datetime',
    ];

    /**
     * Write code on Method
     *
     * @return \Jenssegers\Mongodb\Relations\BelongsTo()
     */

    //  Jenssegers\Mongodb\Relations\BelongsTo;
    public function user(): \Jenssegers\Mongodb\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel; 

class UserProfile extends EloquentModel
{
    use HasFactory;

    // protected $table = 'users_verify';

    /**
     * Write code on Method
     *
     * @return response()
     */

     protected $connection = 'mongodb';
     protected $collection = 'users_profile';

     protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'school',
        'gender',
        'age',
        'state',
        'lga',
        'user_image',
    ];

    // protected $casts = [
    //     'expiresAt' => 'datetime',
    // ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute(){
        return asset('storage/images/' . $this->user_image);
    }

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


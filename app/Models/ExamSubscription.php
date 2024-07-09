<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;


class ExamSubscription extends EloquentModel
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'exams_subscription_status';


    protected $fillable = [
        'status',
        'email'
    ];
}

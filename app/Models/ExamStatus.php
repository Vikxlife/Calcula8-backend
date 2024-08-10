<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Jenssegers\Mongodb\Relations\BelongsTo;

class ExamStatus extends EloquentModel
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'exams_status';


    protected $fillable = [
        'question_id',
        'skipped',
        'answered',
        'option_chosen',
        'correct_option',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

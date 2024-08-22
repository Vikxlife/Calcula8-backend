<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Jenssegers\Mongodb\Relations\BelongsTo;

class ExamResult extends EloquentModel
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'exam_results';


    protected $fillable = [
        'exam_type',
        'answered',
        'correct',
        'incorrect',
        'skipped',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}

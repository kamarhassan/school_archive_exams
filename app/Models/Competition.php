<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
   protected $fillable = [
        'teacher_name',
        'shift',
        'grade',
        'subject',
        'divisions',
        'competition_file',
        'answer_key_file',
    ];

    protected $casts = [
        'divisions' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'subject_id',
        'class_name',
        'exam',
        'semester',
        'note',
    ];
}
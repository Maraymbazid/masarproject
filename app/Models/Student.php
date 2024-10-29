<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $casts = [
        'birth_date' => 'date',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'region',
        'sexe',
        'class_name',
    ];
}

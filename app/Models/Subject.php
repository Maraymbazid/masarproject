<?php

namespace App\Models;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function teatchers()
    {
        return $this->hasMany(Teatcher::class, 'subject_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}

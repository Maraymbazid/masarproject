<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'subject_id',     // Foreign key to subjects table
        'semester',       // Semester (e.g., 'Semester 1' or 'Semester 2')
        'number_of_exams', // Number of exams for the specified semester
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public static function existsForSubjectAndSemester($subject_id, $semester)
    {
        return self::where('subject_id', $subject_id)
            ->where('semester', $semester)
            ->exists();
    }
}
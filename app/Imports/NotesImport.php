<?php

namespace App\Imports;

use App\Models\Note;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NotesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $student = Student::find($row['id']); // 'id' should now be part of the row array

        if ($student) {
            return new Note([
                'student_id' => $student->id,
                'teacher_id' => Auth::guard('teacher')->user()->id,
                'subject_id' => Auth::guard('teacher')->user()->subject_id, // Hardcoded subject ID for now
                'class_name' => $row['class'],   // Ensure 'class' matches your Excel header
                'semester' => $row['semester'],
                'exam' => $row['exam'],
                'note' => $row['note'],
            ]);
        }

        return null;
    }
}
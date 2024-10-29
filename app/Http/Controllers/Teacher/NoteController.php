<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Note;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\ClassService;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{



    public function create()
    {
        $teacherId = Auth::guard('teacher')->user()->id;
        $subjectId = Auth::guard('teacher')->user()->subject_id;
        $classes = ClassService::getClassesByTeacher($teacherId);
        $exams = ClassService::getExamsBySubjectId($subjectId);
        return  view('teacher.notes.create', compact('classes', 'exams'));
    }

    public function getStudents(Request $request)
    {
        $subjectId = Auth::guard('teacher')->user()->subject_id;
        $className = $request->input('class_name');
        $semester = $request->input('semester');
        $exam = $request->input('exam');

        $students = Student::where('students.class_name', $className)
            ->leftJoin('notes', function ($join) use ($className, $semester, $exam, $subjectId) {
                $join->on('students.id', '=', 'notes.student_id')
                    ->where('notes.class_name', '=', $className)
                    ->where('notes.semester', '=', $semester)
                    ->where('notes.exam', '=', $exam)
                    ->where('notes.subject_id', '=', $subjectId);
            })
            ->select('students.id', 'students.first_name', 'students.last_name', 'students.sexe', 'notes.note')
            ->get();

        $students->each(function ($student) {
            $student->note = $student->note ?? 0;
        });
        return response()->json([
            'success' => true,
            'data' => $students
        ], 200);
    }

    public function store(Request $request)
    {
        $teacherId = Auth::guard('teacher')->user()->id;
        $subjectId = Auth::guard('teacher')->user()->subject_id;
        $notesData = $request->input('notes');
        $className = $request->input('class_name');
        $semester = $request->input('semester');
        $exam = $request->input('exam');

        foreach ($notesData as $noteData) {
            $this->createOrUpdateNote(
                $noteData['student_id'],
                $teacherId,
                $subjectId,
                $className,
                $noteData['note'],
                $semester,
                $exam
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully.'
        ], 200);
    }

    private function createOrUpdateNote($studentId, $teacherId, $subjectId, $className, $newNote, $semester, $exam)
    {
        $existingNote = Note::where('student_id', $studentId)
            ->where('class_name', $className)
            ->where('subject_id', $subjectId)
            ->where('semester', $semester) // Check by semester
            ->where('exam', $exam) // Check by exam
            ->first();

        if ($existingNote) {
            if ($existingNote->note != $newNote) {
                $existingNote->update([
                    'note' => $newNote,
                ]);
            }
        } else {
            Note::create([
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
                'subject_id' => $subjectId,
                'class_name' => $className,
                'note' => $newNote,
                'semester' => $semester, // Insert semester
                'exam' => $exam, // Insert exam
            ]);
        }
    }
}
<?php

namespace App\Http\Controllers\Supervisor;

use App\Models\Note;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Services\ClassService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StudentNotesRequest;

class NoteController extends Controller
{
    public function create()
    {
        $supervisorId = Auth::guard('supervisor')->user()->id;
        $classes = ClassService::generateClassesBySupervisor($supervisorId);
        //dd($classes);
        $subjects = Subject::all();
        return  view('supervisor.notes.create', compact('classes', 'subjects'));
    }

    public function getExamsBySubjectId(Request $request)
    {
        $subjectId = $request->input('subject_id');

        // Call the function to get exams for the selected subject
        $exams = ClassService::getExamsBySubjectId($subjectId);

        return response()->json(['exams' => $exams]);
    }

    public function index(StudentNotesRequest $request)
    {
        $subjectId = $request->input('subject');
        $className = $request->input('class_name');
        $semester = $request->input('semester');
        $exam = $request->input('exam');

        $students = Student::join('notes', function ($join) use ($className, $semester, $exam, $subjectId) {
            $join->on('students.id', '=', 'notes.student_id')
                ->where('notes.class_name', '=', $className)
                ->where('notes.semester', '=', $semester)
                ->where('notes.exam', '=', $exam)
                ->where('notes.subject_id', '=', $subjectId);
        })
            ->select('students.id', 'students.first_name', 'students.last_name', 'students.sexe', 'notes.note')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $students
        ], 200);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'notes' => 'required|array',
            'notes.*.student_id' => 'required|exists:students,id',
            'notes.*.note' => 'required|numeric|min:0|max:20',
            'class_name' => 'required|string',
            'semester' => 'required|in:Semester 1,Semester 2',
            'exam' => 'required|string',
            'subject' => 'required|exists:subjects,id',
        ]);

        $notesData = $validatedData['notes'];
        $className = $validatedData['class_name'];
        $semester = $validatedData['semester'];
        $exam = $validatedData['exam'];
        $subjectId = $validatedData['subject'];

        DB::beginTransaction();
        try {
            foreach ($notesData as $noteData) {

                $this->updateNoteIfChanged(
                    $noteData['student_id'],
                    $subjectId,
                    $className,
                    $noteData['note'],
                    $semester,
                    $exam
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Notes updated successfully.'
            ], 200);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating notes.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function updateNoteIfChanged($studentId, $subjectId, $className, $newNote, $semester, $exam)
    {

        $existingNote = Note::where('student_id', $studentId)
            ->where('class_name', $className)
            ->where('subject_id', $subjectId)
            ->where('semester', $semester)
            ->where('exam', $exam)
            ->first();

        if ($existingNote && $existingNote->note != $newNote) {
            $existingNote->update(['note' => $newNote]);
        }
    }
}

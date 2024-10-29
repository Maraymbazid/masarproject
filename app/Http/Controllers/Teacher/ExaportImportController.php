<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Student;
use App\Imports\NotesImport;
use Illuminate\Http\Request;
use App\Services\ClassService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExaportImportController extends Controller
{
    public function create()
    {
        $classes = ClassService::getClassesByTeacher(Auth::guard('teacher')->user()->id);
        $exams = ClassService::getExamsBySubjectId(Auth::guard('teacher')->user()->subject_id);
        return view('teacher.notes.export-import.create', compact('classes', 'exams'));
    }

    public function export(Request $request)
    {
        // Retrieve the input values
        $semester = $request->input('semester');
        $control = $request->input('exam');
        $class = $request->input('class_name'); // You can replace this with actual class logic or selection

        // Fetch students for the selected class
        $students = Student::where('class_name', $class)->get(['id', 'first_name', 'last_name', 'class_name']);

        // Map the data into a structure for export
        $data = $students->map(function ($student) use ($semester, $control) {
            return [
                'id' => $student->id,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'class' => $student->class_name,
                'semester' => $semester,
                'exam' => $control,
                'note' => '', // Empty column for notes to be filled by the teacher
            ];
        })->toArray();

        // Generate and return the Excel file
        return Excel::download(new \App\Exports\NotesExport($data), 'notes_template.xlsx');
    }

    public function import(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'file' => 'required|mimes:xlsx',
        // ]);

        // Use the NotesImport class to handle the import logic
        Excel::import(new NotesImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Notes imported successfully!');
    }
}
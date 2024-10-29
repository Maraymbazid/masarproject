<?php

namespace App\Http\Controllers\Supervisor;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\ClassService;
use Illuminate\Support\Carbon;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    public function import(Request $request)
    {
        try {
            $request->validate([
                'class_name' => 'required|string',
                'file' => 'required|mimes:xlsx'
            ]);

            $className = $request->input('class_name');
            Excel::import(new StudentsImport($className), $request->file('file'));
            return redirect()->route('students.index')->with('success', 'Teatchers imported successfully!');
        } catch (\Exception $e) {

            return redirect()->route('students.index')->with(['error' => 'there is somthing wrong try again']);
        }


        return redirect()->back()->with('success', 'Students imported successfully!');
    }

    public function downloadpage()
    {
        return view('supervisor.students.download');
    }
    public function create()
    {
        $classes = ClassService::generateClassesBySupervisor(Auth::guard('supervisor')->user()->id);
        return  view('supervisor.students.create', compact('classes'));
    }

    public function downloadfile()
    {

        return Storage::download('public/templates/student_template_sup.xlsx');
    }

    private function extractClassName(string $jsonString)
    {
        $classesArray = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($classesArray)) {
            return false;
        }

        if (!empty($classesArray)) {
            return $classesArray[0]['value'];
        }

        return false;
    }

    public function index1()
    {
        $supervisorId = Auth::guard('supervisor')->id();

        $classes = ClassService::generateClassesBySupervisor($supervisorId);

        return view('supervisor.students.index', compact('classes'));
    }
    public function index(Request $request)
    {


        if ($request->ajax()) {

            $className = $request->class_name;

            $students = Student::where('class_name', $className)
                ->select(['id', 'first_name', 'last_name', 'birth_date', 'region', 'sexe']);
            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="student_checkbox[]" class="student_checkbox" value="' . $row->id . '">';
                })
                ->editColumn('birth_date', function ($row) {
                    // Format the birth_date column
                    return Carbon::parse($row->birth_date)->format('Y-m-d');
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="student_checkbox[]" class="student_checkbox" value="' . $row->id . '">';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('students.edit', $row->id);
                    $editBtn = '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $deleteBtn = '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }

        return view('supervisor.students.index');
    }

    public function export(Request $request, $format)
    {
        $supervisorId = Auth::guard('supervisor')->id();
        $supervisorClasses = ClassService::generateClassesBySupervisor($supervisorId);

        $students = Student::whereIn('class_name', $supervisorClasses)
            ->select(['id', 'first_name', 'last_name', 'birth_date', 'region', 'sexe', 'class_name'])->get();

        if ($format == 'csv') {
            return Excel::download(new StudentsExport($students), 'students.csv');
        } elseif ($format == 'excel') {
            return Excel::download(new StudentsExport($students), 'students.xlsx');
        } elseif ($format == 'pdf') {
            $pdf = PDF::loadView('supervisor.students.exports.students', compact('students'));
            return $pdf->download('students.pdf');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {

            return redirect()->route('students.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function edit($id)
    {
        try {
            $student = Student::findOrFail($id);
            return view('supervisor.students.edit', compact('student'));
        } catch (\Exception $e) {

            return redirect()->route('students.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function  update(Request $request, Student $student)
    {

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date_format:Y-m-d',
            'region' => 'required|string|max:255',
            'sexe' => 'required|in:f,m',
        ]);

        try {

            $student->update($validatedData);

            return redirect()->route('students.index')->with('success', 'Student updated successfully!');
        } catch (\Exception $e) {

            return redirect()->route('students.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function deleteall(Request $request)
    {
        // Retrieve the IDs from the request
        $ids = $request->ids;

        try {

            if (!empty($ids)) {

                Student::whereIn('id', $ids)->delete();
            } else {
                return response()->json(['message' => 'No IDs provided'], 400);
            }

            return response()->json(['message' => 'Success', 'deleted_ids' => $ids]);
        } catch (\Exception $e) {


            return response()->json(['message' => 'Failed to delete students', 'error' => $e->getMessage()], 500);
        }
    }

    public function editstudents(Request $request)
    {

        $ids = explode(',', $request->query('ids'));
        $students = Student::whereIn('id', $ids)->get();
        return view('supervisor.students.editsomestudents', compact('students'));
    }

    public function updateSelectedStudents(Request $request)
    {
        $studentsData = $request->input('students');

        foreach ($studentsData as $studentData) {
            $student = Student::find($studentData['id']);
            $student->update($studentData);
        }

        return redirect()->route('students.index')->with('success', 'Selected students updated successfully.');
    }

    public function createonestudent()
    {
        $classes = ClassService::generateClassesBySupervisor(Auth::guard('supervisor')->user()->id);
        return view('supervisor.students.addonestudent', compact('classes'));
    }
    public function addonestudent(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date_format:Y-m-d',
            'region' => 'required|string|max:255',
            'sexe' => 'required|in:f,m',
            'class_name' => 'required|string|max:255'
        ]);
        $className = $request->input('class_name');
        $validatedData['class_name'] = $className;

        try {

            Student::create($validatedData);

            return redirect()->route('students.index')->with('success', 'Student created successfully!');
        } catch (\Exception $e) {

            return redirect()->route('students.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
}






















//
// Yes, in Laravel, the structure of the data retrieved by request()->input() is determined by how the name attributes of the form inputs are defined.

// How request()->input() Works:
// Basic Inputs:

// If you have a simple input with a name attribute like name="first_name", then request()->input('first_name') will return the value of that input field as a string.
// Array Inputs:

// If you use a name attribute like name="students[first_name]", Laravel will return an associative array where the key is first_name and the value is the submitted value for that field.
// Example <input type="text" name="students[first_name]" value="John">
// request()->input('students') will return:

// [
//     'first_name' => 'John'
// ]
// Nested Array Structure:
// Multi-Dimensional Arrays:
// If you structure your input names to include multiple levels, like students[student_id][field_name], Laravel will treat it as a multi-dimensional array.
// Example:
// php
// Copy code
// <input type="text" name="students[1][first_name]" value="John">
// <input type="text" name="students[1][last_name]" value="Doe">
// <input type="text" name="students[2][first_name]" value="Jane">
// <input type="text" name="students[2][last_name]" value="Smith">
// request()->input('students') will return:

// [
//     1 => [
//         'first_name' => 'John',
//         'last_name' => 'Doe',
//     ],
//     2 => [
//         'first_name' => 'Jane',
//         'last_name' => 'Smith',
//     ]
// ]
// General Rule:
// Yes, if you structure your form inputs with a name attribute following the pattern students[student_id][field_name], then request()->input('students') will return an array where each key corresponds to the student_id, and each value is an associative array containing the field_name and its respective value
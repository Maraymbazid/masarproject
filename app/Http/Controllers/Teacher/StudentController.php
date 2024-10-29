<?php

namespace App\Http\Controllers\teacher;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\ClassService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function getStudentsbyteachers(Request $request)
    {
        $className = $request->input('class_name');

        $students = Student::where('students.class_name', $className)

            ->select('first_name', 'last_name', 'sexe', 'class_name')
            ->get();


        return response()->json([
            'success' => true,
            'data' => $students
        ], 200);
    }

    public function index()
    {
        $classes = ClassService::getClassesByTeacher(Auth::guard('teacher')->user()->id);
        return view('teacher.ListofStudents.index', compact('classes'));
    }
}
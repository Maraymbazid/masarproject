<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Classe;
use App\Models\Subject;
use App\Models\Teatcher;
use App\Models\Supervisor;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\DB;

class ClassService
{
    protected $classe = [];

    public static function getClasse()
    {

        $items = Classe::all(); // Fetch all TagItem records

        foreach ($items as $item) {
            for ($i = 1; $i <= $item->number; $i++) {
                $classe[] = $item->name . $i;
            }
        }

        return $classe;
    }
    public static function getClassesByTeacher($teacherId)
    {
        // Retrieve the classes for the given teacher ID
        $classes = TeacherClass::where('teacher_id', $teacherId)->pluck('class_name');

        return $classes;
    }
    public static function getExamsBySubjectId($subjectId)
    {

        $examRecord = Exam::where('subject_id', $subjectId)->first();

        if (!$examRecord) {
            return [];
        }

        $numberOfExams = $examRecord->number_of_exams;
        $exams = [];

        for ($i = 1; $i <= $numberOfExams; $i++) {
            $exams[] = "control $i";
        }

        $exams[] = "activities";

        return $exams;
    }

    public function getTotalSubjects()
    {
        return Subject::count();
    }


    public function getTotalTeachers()
    {
        return Teatcher::count();
    }

    public function getTotalSupervisors()
    {
        return Supervisor::count();
    }


    public function getAllClasses()
    {
        return Classe::count();
    }

    public static function gettotalstudentsforoneteacher($teacherId)
    {
        $totalStudents = DB::table('teacher_class')
            ->join('students', 'teacher_class.class_name', '=', 'students.class_name')
            ->where('teacher_class.teacher_id', $teacherId)
            ->count();

        return $totalStudents;
    }

    public static function gettotalclassesforoneteacher($teacherId)
    {
        $totalClasses = DB::table('teacher_class')
            ->where('teacher_class.teacher_id', $teacherId)
            ->count();

        return $totalClasses;
    }

    function getDistinctLevelsByTeacher($teacherId)
    {
        // Use a query to retrieve distinct levels (the first number of class names)
        $distinctLevels = DB::table('teacher_class')
            ->select(DB::raw('LEFT(class_name, 1) as level')) // Assuming the level is the first character
            ->where('teacher_id', $teacherId)
            ->groupBy('level')
            ->get();

        // Return the count of distinct levels
        return $distinctLevels->count();
    }


    public static  function generateClassesBySupervisor($supervisorId)
    {

        $items = Classe::where('supervisor_id', $supervisorId)->get();

        $classes = [];

        foreach ($items as $item) {

            for ($i = 1; $i <= $item->number; $i++) {
                $classes[] = $item->name . $i;
            }
        }

        return $classes;
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function create()
    {
        $subjects = Subject::all();

        return view('admin.exams.create', compact('subjects'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'subject_id' => 'required|exists:subjects,id', // Ensure the subject exists
            'semester' => 'required|in:Semester 1,Semester 2', // Validate semester value
            'number_of_exams' => 'required|integer|min:1', // Ensure at least one exam
        ]);

        if (Exam::existsForSubjectAndSemester($request->input('subject_id'), $request->input('semester'))) {
            return redirect()->route('exams.index')->with(['error' => 'An exam for this subject and semester already exists.']);
        }

        try {
            Exam::create([
                'subject_id' => $request->input('subject_id'),
                'semester' => $request->input('semester'),
                'number_of_exams' => $request->input('number_of_exams'),
            ]);

            return redirect()->route('exams.index')->with(['success' => 'Exams has been added successfully']);;
        } catch (\Exception $e) {

            return redirect()->route('exams.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function index()
    {
        try {
            $exams = Exam::with('subject')->get();
            return view('admin.exams.index', compact('exams'));
        } catch (\Exception $e) {

            return redirect()->route('exams.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function edit($id)
    {
        try {
            $exam = Exam::findOrFail($id);

            return view('admin.exams.edit', compact('exam'));
        } catch (\Exception $e) {

            return redirect()->route('exams.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'number_of_exams' => 'required|int|min:1',
        ]);

        try {
            $exam->update([
                'number_of_exams' => $validated['number_of_exams'],
            ]);

            return redirect()->route('exams.index')->with('success', 'Exam updated successfully!');
        } catch (\Exception $e) {

            return redirect()->route('exams.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function destroy($id)
    {
        try {
            $exam = Exam::findOrFail($id);
            $exam->delete();

            return redirect()->route('exams.index')->with('success', 'Exam deleted successfully!');
        } catch (\Exception $e) {

            return redirect()->route('exams.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
}
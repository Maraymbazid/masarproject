<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:subjects,name',
        ]);

        try {
            $subject = Subject::create([
                'name' => $validated['name'],
            ]);

            return redirect()->route('admin.subjects.index');
        } catch (\Exception $e) {

            return redirect()->route('admin.subjects.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function index()
    {
        try {
            $subjects = Subject::all();
            return view('admin.subjects.index', compact('subjects'));
        } catch (\Exception $e) {

            return redirect()->route('admin.subjects.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function edit($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            return view('admin.subjects.show', compact('subject'));
        } catch (\Exception $e) {

            return redirect()->route('admin.subjects.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:subjects,name,' . $subject->id,
        ]);

        try {
            $subject->update([
                'name' => $validated['name'],
            ]);

            return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
        } catch (\Exception $e) {

            return redirect()->route('admin.subjects.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully!');
        } catch (\Exception $e) {

            return redirect()->route('admin.subjects.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
}
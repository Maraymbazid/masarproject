<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
    public function create()
    {
        $supervisors = Supervisor::all();
        return view('admin.classess.create', compact('supervisors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|in:"1-APIC","2-APIC","3-APIC"',
            'number' => 'required|integer',
            'supervisor_id' => 'required|integer|exists:supervisors,id',

        ]);

        try {
            $classe = Classe::create([
                'name' => $validated['name'],
                'number' => $validated['number'],
                'supervisor_id' => $validated['supervisor_id'],
            ]);

            return redirect()->route('classes.index')->with(['success' => 'the class has been created successefully']);;
        } catch (\Exception $e) {

            return redirect()->route('classes.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function index()
    {

        try {
            $classess = Classe::all();
            return view('admin.classess.index', compact('classess'));
        } catch (\Exception $e) {

            return redirect()->route('classes.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function edit($id)
    {
        try {
            $classe = Classe::findOrFail($id);
            $supervisors = Supervisor::all();
            return view('admin.classess.edit', compact('classe', 'supervisors'));
        } catch (\Exception $e) {

            return redirect()->route('classes.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function update(Request $request, Classe $class)
    {

        $validated = $request->validate([
            'number' => 'required|integer|',
            'supervisor_id' => 'required|integer|exists:supervisors,id',
        ]);

        try {
            $class->update([
                'number' => $validated['number'],
                'supervisor_id' => $validated['supervisor_id']
            ]);

            return redirect()->route('classes.index')->with('success', 'Class updated successfully!');
        } catch (\Exception $e) {

            return redirect()->route('classes.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function destroy($id)
    {
        try {
            $classe = Classe::findOrFail($id);
            $classe->delete();

            return redirect()->route('classes.index')->with('success', 'Class deleted successfully!');
        } catch (\Exception $e) {

            return redirect()->route('classes.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
}
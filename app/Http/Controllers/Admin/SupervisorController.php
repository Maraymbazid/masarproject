<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Rules\ValidateTeatcherName;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Traits\GeneratesCredentials;

class SupervisorController extends Controller
{
    use GeneratesCredentials;

    public function create()
    {

        return view('admin.supervisors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                new ValidateTeatcherName,
                'unique:supervisors,name',
            ],
            'ppr' => 'required|string|min:5|unique:supervisors,ppr',

        ]);

        try {
            $credentials = $this->generateCredentials($validated['name']);
            $supervisor = Supervisor::create([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'name' => $validated['name'],
                'ppr' => $validated['ppr'],
                'province' => 'tarfaya',
                'etablissement' => 'ibn_tomert',

            ]);

            return redirect()->route('supervisors.index')->with('success', 'Teatcher created successfully!');
        } catch (\Exception $e) {

            return redirect()->route('supervisors.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function index()
    {
        try {
            $supervisors = Supervisor::get();
            return view('admin.supervisors.index', compact('supervisors'));
        } catch (\Exception $e) {

            return redirect()->route('supervisors.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function show($id)
    {
        try {
            $supervisor = Supervisor::findOrFail($id);
            return view('admin.supervisors.show', compact('supervisor'));
        } catch (\Exception $e) {

            return redirect()->route('supervisors.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function edit($id)
    {
        try {
            $supervisor = Supervisor::findOrFail($id);
            return view('admin.supervisors.edit', compact('supervisor'));
        } catch (\Exception $e) {

            return redirect()->route('supervisors.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function  update(Request $request, Supervisor $supervisor)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                new ValidateTeatcherName,
                'unique:supervisors,name,' . $supervisor->id,
            ],
            'ppr' => 'required|string|min:5|unique:supervisors,ppr,' . $supervisor->id,

        ]);

        try {
            if ($request->input('name') !== $supervisor->name) {
                $credentials = $this->generateCredentials($request->input('name'));
                $supervisor->name = $request->input('name');
                $supervisor->email = $credentials['email'];
                $supervisor->password = $credentials['password'];
            }
            $supervisor->ppr = $request->ppr;
            $supervisor->save();
            return redirect()->route('supervisors.index')->with('success', 'Teatcher updated successfully!');
        } catch (\Exception $e) {

            return redirect()->route('supervisors.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function destroy($id)
    {
        try {
            $supervisor = Supervisor::findOrFail($id);
            $supervisor->delete();

            return redirect()->route('supervisors.index')->with('success', 'Teatcher deleted successfully!');
        } catch (\Exception $e) {

            return redirect()->route('supervisors.index')->with(['error' => 'Failed to delete subject.']);
        }
    }
}
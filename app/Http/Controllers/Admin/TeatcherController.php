<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Models\Teatcher;
use Illuminate\Http\Request;
use App\Rules\ValidateTeatcherName;
use App\Http\Controllers\Controller;
use App\Traits\GeneratesCredentials;
use Illuminate\Support\Facades\Crypt;

class TeatcherController extends Controller
{
    use GeneratesCredentials;

    public function create()
    {
        $subjects = Subject::all();

        return view('admin.teatchers.create', compact('subjects'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                new ValidateTeatcherName,
                'unique:teachers,name',
            ],
            'ppr' => 'required|string|min:5|unique:teachers,ppr',
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        try {
            $credentials = $this->generateCredentials($validated['name']);
            $teatcher = Teatcher::create([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'name' => $validated['name'],
                'ppr' => $validated['ppr'],
                'subject_id' => $validated['subject_id'],
                'province' => 'tarfaya',
                'etablissement' => 'ibn_tomert',

            ]);
            $classNames = $this->extractClassNames($request->input('classe-names'));

            if ($classNames === false) {
                return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
            }

            foreach ($classNames as $className) {
                $teatcher->attachClass($className);
            }


            return redirect()->route('teatchers.index')->with('success', 'Teatcher created successfully!');
        } catch (\Exception $e) {

            return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function index()
    {
        try {
            $teatchers = Teatcher::with('subject')->get();
            return view('admin.teatchers.index', compact('teatchers'));
        } catch (\Exception $e) {

            return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function show($id)
    {
        try {
            $teatcher = Teatcher::findOrFail($id);
            return view('admin.teatchers.show', compact('teatcher'));
        } catch (\Exception $e) {

            return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function edit($id)
    {
        try {
            $subjects = Subject::all();
            $teatcher = Teatcher::findOrFail($id);

            return view('admin.teatchers.edit', compact('teatcher', 'subjects'));
        } catch (\Exception $e) {

            return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }
    public function  update(Request $request, Teatcher $teatcher)
    {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                new ValidateTeatcherName,
                'unique:teachers,name,' . $teatcher->id,
            ],
            'ppr' => 'required|string|min:5|unique:teachers,ppr,' . $teatcher->id,
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        try {
            if ($request->input('name') !== $teatcher->name) {
                $credentials = $this->generateCredentials($request->input('name'));
                $teatcher->name = $request->input('name');
                $teatcher->email = $credentials['email'];
                $teatcher->password = $credentials['password'];
            }
            $teatcher->ppr = $request->ppr;
            $teatcher->subject_id = $request->subject_id;
            $teatcher->save();
            $classNames = $this->extractClassNames($request->input('classe-names'));

            if ($classNames === false) {
                return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
            }
            $teatcher->updateClasses($classNames);


            return redirect()->route('teatchers.index')->with('success', 'Teatcher updated successfully!');
        } catch (\Exception $e) {

            return redirect()->route('teatchers.index')->with(['error' => 'there is somthing wrong try again']);
        }
    }

    public function destroy($id)
    {
        try {
            $teatcher = Teatcher::findOrFail($id);
            $teatcher->delete();

            return redirect()->route('teatchers.index')->with('success', 'Teatcher deleted successfully!');
        } catch (\Exception $e) {

            return redirect()->route('teatchers.index')->with(['error' => 'Failed to delete subject.']);
        }
    }

    private function extractClassNames(string $jsonString)
    {

        $classesArray = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($classesArray)) {
            return false;
        }
        return array_map(function ($item) {
            return $item['value'];
        }, $classesArray);
    }
}
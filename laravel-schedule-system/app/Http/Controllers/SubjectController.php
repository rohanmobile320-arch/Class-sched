<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show']);
    }

    public function index()
    {
        $subjects = Subject::paginate(15);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|unique:subjects|max:20',
            'subject_name' => 'required|max:255',
            'units' => 'required|integer|min:1|max:5',
            'description' => 'nullable|max:1000',
            'is_active' => 'boolean',
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'required|unique:subjects,subject_code,' . $subject->id . '|max:20',
            'subject_name' => 'required|max:255',
            'units' => 'required|integer|min:1|max:5',
            'description' => 'nullable|max:1000',
            'is_active' => 'boolean',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}

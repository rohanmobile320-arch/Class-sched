<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show']);
    }

    public function index()
    {
        $instructors = Instructor::paginate(15);
        return view('admin.instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('admin.instructors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:instructors|max:20',
            'full_name' => 'required|max:255',
            'email' => 'required|unique:instructors|email|max:255',
            'contact_number' => 'nullable|max:20',
            'department' => 'required|max:255',
            'academic_rank' => 'nullable|max:255',
            'is_active' => 'boolean',
        ]);

        Instructor::create($validated);

        return redirect()->route('instructors.index')->with('success', 'Instructor created successfully.');
    }

    public function show(Instructor $instructor)
    {
        return view('admin.instructors.show', compact('instructor'));
    }

    public function edit(Instructor $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:instructors,employee_id,' . $instructor->id . '|max:20',
            'full_name' => 'required|max:255',
            'email' => 'required|unique:instructors,email,' . $instructor->id . '|email|max:255',
            'contact_number' => 'nullable|max:20',
            'department' => 'required|max:255',
            'academic_rank' => 'nullable|max:255',
            'is_active' => 'boolean',
        ]);

        $instructor->update($validated);

        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully.');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully.');
    }
}

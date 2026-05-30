<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show', 'mySchedule']);
    }

    public function index()
    {
        $students = Student::with('section')->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $sections = Section::where('is_active', true)->get();
        return view('admin.students.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'required|unique:students|max:20',
            'full_name' => 'required|max:255',
            'email' => 'required|unique:students|email|max:255',
            'section_id' => 'required|exists:sections,id',
            'course' => 'required|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'enrollment_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Create user account for student
        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'), // Default password
            'role' => 'student',
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $validated['user_id'] = $user->id;
        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $sections = Section::where('is_active', true)->get();
        return view('admin.students.edit', compact('student', 'sections'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_number' => 'required|unique:students,student_number,' . $student->id . '|max:20',
            'full_name' => 'required|max:255',
            'email' => 'required|unique:students,email,' . $student->id . '|email|max:255',
            'section_id' => 'required|exists:sections,id',
            'course' => 'required|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'enrollment_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $student->user->update([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function mySchedule()
    {
        $student = auth()->user()->student;
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Student record not found.');
        }

        $schedules = $student->getClassSchedules();
        return view('student.schedule', compact('schedules'));
    }
}

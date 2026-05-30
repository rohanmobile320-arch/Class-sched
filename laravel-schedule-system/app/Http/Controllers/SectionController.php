<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show']);
    }

    public function index()
    {
        $sections = Section::paginate(15);
        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_code' => 'required|unique:sections|max:20',
            'section_name' => 'required|max:255',
            'course' => 'required|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'student_capacity' => 'required|integer|min:10|max:100',
            'is_active' => 'boolean',
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    public function show(Section $section)
    {
        return view('admin.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'section_code' => 'required|unique:sections,section_code,' . $section->id . '|max:20',
            'section_name' => 'required|max:255',
            'course' => 'required|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'student_capacity' => 'required|integer|min:10|max:100',
            'is_active' => 'boolean',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }
}

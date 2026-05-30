<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Instructor;
use App\Models\Section;
use App\Models\Room;
use App\Services\ScheduleConflictService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $conflictService;

    public function __construct(ScheduleConflictService $conflictService)
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show', 'mySchedule']);
        $this->conflictService = $conflictService;
    }

    public function index()
    {
        $schedules = Schedule::with('subject', 'instructor', 'section', 'room')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->paginate(15);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $subjects = Subject::where('is_active', true)->get();
        $instructors = Instructor::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.schedules.create', compact('subjects', 'instructors', 'sections', 'rooms', 'daysOfWeek'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:instructors,id',
            'section_id' => 'required|exists:sections,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'semester' => 'required|integer|min:1|max:2',
            'academic_year' => 'required|max:20',
            'status' => 'required|in:active,inactive,cancelled',
            'notes' => 'nullable|max:1000',
        ]);

        // Check for conflicts
        $conflicts = $this->conflictService->checkAllConflicts(
            $validated['room_id'],
            $validated['instructor_id'],
            $validated['section_id'],
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time']
        );

        if (!empty($conflicts)) {
            return back()->withInput()->withErrors(['conflicts' => implode(' ', $conflicts)]);
        }

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $subjects = Subject::where('is_active', true)->get();
        $instructors = Instructor::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.schedules.edit', compact('schedule', 'subjects', 'instructors', 'sections', 'rooms', 'daysOfWeek'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:instructors,id',
            'section_id' => 'required|exists:sections,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'semester' => 'required|integer|min:1|max:2',
            'academic_year' => 'required|max:20',
            'status' => 'required|in:active,inactive,cancelled',
            'notes' => 'nullable|max:1000',
        ]);

        // Check for conflicts (excluding current schedule)
        $conflicts = $this->conflictService->checkAllConflicts(
            $validated['room_id'],
            $validated['instructor_id'],
            $validated['section_id'],
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time'],
            $schedule->id
        );

        if (!empty($conflicts)) {
            return back()->withInput()->withErrors(['conflicts' => implode(' ', $conflicts)]);
        }

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
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

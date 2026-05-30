<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getTotalStatistics()
    {
        return [
            'total_students' => Student::count(),
            'total_instructors' => Instructor::count(),
            'total_subjects' => Subject::count(),
            'total_schedules' => Schedule::count(),
        ];
    }

    public function getSchedulesByInstructor($instructorId)
    {
        return Schedule::where('instructor_id', $instructorId)
            ->with('subject', 'section', 'room')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    public function getSchedulesBySection($sectionId)
    {
        return Schedule::where('section_id', $sectionId)
            ->with('subject', 'instructor', 'room')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    public function getSchedulesByRoom($roomId)
    {
        return Schedule::where('room_id', $roomId)
            ->with('subject', 'instructor', 'section')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    public function getConflictReport()
    {
        // Find potential conflicts by checking overlapping times
        $conflicts = [];

        $schedules = Schedule::where('status', 'active')
            ->orderBy('room_id')
            ->get();

        foreach ($schedules as $schedule) {
            $roomConflicts = Schedule::where('id', '!=', $schedule->id)
                ->where('room_id', $schedule->room_id)
                ->where('day_of_week', $schedule->day_of_week)
                ->where('status', 'active')
                ->where(function ($q) use ($schedule) {
                    $q->whereBetween('start_time', [$schedule->start_time, $schedule->end_time])
                      ->orWhereBetween('end_time', [$schedule->start_time, $schedule->end_time]);
                })
                ->count();

            if ($roomConflicts > 0) {
                $conflicts[] = [
                    'schedule_id' => $schedule->id,
                    'subject' => $schedule->subject->subject_name,
                    'room' => $schedule->room->room_number,
                    'day' => $schedule->day_of_week,
                    'time' => $schedule->start_time . ' - ' . $schedule->end_time,
                    'conflict_count' => $roomConflicts,
                ];
            }
        }

        return $conflicts;
    }

    public function getInstructorLoadReport()
    {
        return Instructor::withCount(['schedules' => function ($q) {
            $q->where('status', 'active');
        }])->with('schedules')->get();
    }

    public function getRoomUtilizationReport()
    {
        return DB::table('rooms')
            ->leftJoin('schedules', 'rooms.id', '=', 'schedules.room_id')
            ->selectRaw('rooms.room_number, rooms.building, COUNT(schedules.id) as total_schedules')
            ->groupBy('rooms.id', 'rooms.room_number', 'rooms.building')
            ->orderByDesc('total_schedules')
            ->get();
    }
}

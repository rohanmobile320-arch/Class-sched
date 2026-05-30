<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleConflictService
{
    public function checkRoomConflict($roomId, $dayOfWeek, $startTime, $endTime, $scheduleId = null)
    {
        $query = Schedule::where('room_id', $roomId)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'active');

        if ($scheduleId) {
            $query->where('id', '!=', $scheduleId);
        }

        return $query->where(function ($q) use ($startTime, $endTime) {
            $q->whereBetween('start_time', [$startTime, $endTime])
              ->orWhereBetween('end_time', [$startTime, $endTime])
              ->orWhere(function ($subQ) use ($startTime, $endTime) {
                  $subQ->where('start_time', '<=', $startTime)
                       ->where('end_time', '>=', $endTime);
              });
        })->exists();
    }

    public function checkInstructorConflict($instructorId, $dayOfWeek, $startTime, $endTime, $scheduleId = null)
    {
        $query = Schedule::where('instructor_id', $instructorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'active');

        if ($scheduleId) {
            $query->where('id', '!=', $scheduleId);
        }

        return $query->where(function ($q) use ($startTime, $endTime) {
            $q->whereBetween('start_time', [$startTime, $endTime])
              ->orWhereBetween('end_time', [$startTime, $endTime])
              ->orWhere(function ($subQ) use ($startTime, $endTime) {
                  $subQ->where('start_time', '<=', $startTime)
                       ->where('end_time', '>=', $endTime);
              });
        })->exists();
    }

    public function checkSectionConflict($sectionId, $dayOfWeek, $startTime, $endTime, $scheduleId = null)
    {
        $query = Schedule::where('section_id', $sectionId)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'active');

        if ($scheduleId) {
            $query->where('id', '!=', $scheduleId);
        }

        return $query->where(function ($q) use ($startTime, $endTime) {
            $q->whereBetween('start_time', [$startTime, $endTime])
              ->orWhereBetween('end_time', [$startTime, $endTime])
              ->orWhere(function ($subQ) use ($startTime, $endTime) {
                  $subQ->where('start_time', '<=', $startTime)
                       ->where('end_time', '>=', $endTime);
              });
        })->exists();
    }

    public function checkAllConflicts($roomId, $instructorId, $sectionId, $dayOfWeek, $startTime, $endTime, $scheduleId = null)
    {
        $conflicts = [];

        if ($this->checkRoomConflict($roomId, $dayOfWeek, $startTime, $endTime, $scheduleId)) {
            $conflicts[] = 'Room is already booked at this time.';
        }

        if ($this->checkInstructorConflict($instructorId, $dayOfWeek, $startTime, $endTime, $scheduleId)) {
            $conflicts[] = 'Instructor is already assigned to another class at this time.';
        }

        if ($this->checkSectionConflict($sectionId, $dayOfWeek, $startTime, $endTime, $scheduleId)) {
            $conflicts[] = 'Section already has a class scheduled at this time.';
        }

        return $conflicts;
    }
}

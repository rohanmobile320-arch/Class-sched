<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            // Monday schedules
            [
                'subject_id' => 1,
                'instructor_id' => 1,
                'section_id' => 1,
                'room_id' => 1,
                'day_of_week' => 'Monday',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            [
                'subject_id' => 5,
                'instructor_id' => 3,
                'section_id' => 1,
                'room_id' => 2,
                'day_of_week' => 'Monday',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            // Tuesday schedules
            [
                'subject_id' => 2,
                'instructor_id' => 2,
                'section_id' => 1,
                'room_id' => 6,
                'day_of_week' => 'Tuesday',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            [
                'subject_id' => 6,
                'instructor_id' => 3,
                'section_id' => 1,
                'room_id' => 3,
                'day_of_week' => 'Tuesday',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            // Wednesday schedules
            [
                'subject_id' => 3,
                'instructor_id' => 5,
                'section_id' => 1,
                'room_id' => 1,
                'day_of_week' => 'Wednesday',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            [
                'subject_id' => 1,
                'instructor_id' => 1,
                'section_id' => 1,
                'room_id' => 2,
                'day_of_week' => 'Wednesday',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            // Thursday schedules
            [
                'subject_id' => 4,
                'instructor_id' => 2,
                'section_id' => 1,
                'room_id' => 4,
                'day_of_week' => 'Thursday',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            [
                'subject_id' => 7,
                'instructor_id' => 4,
                'section_id' => 1,
                'room_id' => 3,
                'day_of_week' => 'Thursday',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            // Friday schedules
            [
                'subject_id' => 2,
                'instructor_id' => 2,
                'section_id' => 1,
                'room_id' => 1,
                'day_of_week' => 'Friday',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
            [
                'subject_id' => 5,
                'instructor_id' => 3,
                'section_id' => 1,
                'room_id' => 7,
                'day_of_week' => 'Friday',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'semester' => 1,
                'academic_year' => '2024-2025',
                'status' => 'active',
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}

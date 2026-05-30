<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        $instructors = [
            ['employee_id' => 'EMP001', 'full_name' => 'Dr. Maria Santos', 'email' => 'maria.santos@university.com', 'department' => 'Computer Science', 'academic_rank' => 'Associate Professor'],
            ['employee_id' => 'EMP002', 'full_name' => 'Prof. Juan Dela Cruz', 'email' => 'juan.delacruz@university.com', 'department' => 'Computer Science', 'academic_rank' => 'Professor'],
            ['employee_id' => 'EMP003', 'full_name' => 'Dr. Anna Garcia', 'email' => 'anna.garcia@university.com', 'department' => 'Mathematics', 'academic_rank' => 'Associate Professor'],
            ['employee_id' => 'EMP004', 'full_name' => 'Prof. Robert Lee', 'email' => 'robert.lee@university.com', 'department' => 'Physics', 'academic_rank' => 'Professor'],
            ['employee_id' => 'EMP005', 'full_name' => 'Dr. Patricia Wong', 'email' => 'patricia.wong@university.com', 'department' => 'Computer Science', 'academic_rank' => 'Assistant Professor'],
            ['employee_id' => 'EMP006', 'full_name' => 'Prof. David Brown', 'email' => 'david.brown@university.com', 'department' => 'Engineering', 'academic_rank' => 'Associate Professor'],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create(array_merge($instructor, ['is_active' => true]));
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Get the student users
        $johnUser = User::where('email', 'john.doe@student.com')->first();
        $janeUser = User::where('email', 'jane.smith@student.com')->first();
        $bobUser = User::where('email', 'bob.johnson@student.com')->first();

        $students = [
            [
                'user_id' => $johnUser->id,
                'student_number' => 'STU001',
                'full_name' => 'John Doe',
                'email' => 'john.doe@student.com',
                'section_id' => 1,
                'course' => 'BS Computer Science',
                'year_level' => 1,
            ],
            [
                'user_id' => $janeUser->id,
                'student_number' => 'STU002',
                'full_name' => 'Jane Smith',
                'email' => 'jane.smith@student.com',
                'section_id' => 1,
                'course' => 'BS Computer Science',
                'year_level' => 1,
            ],
            [
                'user_id' => $bobUser->id,
                'student_number' => 'STU003',
                'full_name' => 'Bob Johnson',
                'email' => 'bob.johnson@student.com',
                'section_id' => 2,
                'course' => 'BS Computer Science',
                'year_level' => 1,
            ],
        ];

        foreach ($students as $student) {
            Student::create(array_merge($student, ['is_active' => true]));
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['subject_code' => 'CS101', 'subject_name' => 'Introduction to Computer Science', 'units' => 3],
            ['subject_code' => 'CS102', 'subject_name' => 'Programming Fundamentals', 'units' => 4],
            ['subject_code' => 'CS201', 'subject_name' => 'Data Structures', 'units' => 3],
            ['subject_code' => 'CS202', 'subject_name' => 'Algorithms', 'units' => 3],
            ['subject_code' => 'MATH101', 'subject_name' => 'Calculus I', 'units' => 4],
            ['subject_code' => 'MATH102', 'subject_name' => 'Linear Algebra', 'units' => 3],
            ['subject_code' => 'PHYS101', 'subject_name' => 'Physics I', 'units' => 4],
            ['subject_code' => 'ENG101', 'subject_name' => 'English Composition', 'units' => 3],
        ];

        foreach ($subjects as $subject) {
            Subject::create(array_merge($subject, ['is_active' => true]));
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['section_code' => 'BSCS-1A', 'section_name' => 'First Year - Section A', 'course' => 'BS Computer Science', 'year_level' => 1],
            ['section_code' => 'BSCS-1B', 'section_name' => 'First Year - Section B', 'course' => 'BS Computer Science', 'year_level' => 1],
            ['section_code' => 'BSCS-2A', 'section_name' => 'Second Year - Section A', 'course' => 'BS Computer Science', 'year_level' => 2],
            ['section_code' => 'BSCS-3A', 'section_name' => 'Third Year - Section A', 'course' => 'BS Computer Science', 'year_level' => 3],
            ['section_code' => 'BSCE-1A', 'section_name' => 'First Year - Section A', 'course' => 'BS Civil Engineering', 'year_level' => 1],
            ['section_code' => 'BSBM-1A', 'section_name' => 'First Year - Section A', 'course' => 'BS Business Management', 'year_level' => 1],
        ];

        foreach ($sections as $section) {
            Section::create(array_merge($section, ['student_capacity' => 50, 'is_active' => true]));
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            SectionSeeder::class,
            RoomSeeder::class,
            InstructorSeeder::class,
            StudentSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}

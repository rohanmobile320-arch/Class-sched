<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SchedulesExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Schedule::with('subject', 'instructor', 'section', 'room')
            ->get()
            ->map(function ($schedule) {
                return [
                    'ID' => $schedule->id,
                    'Subject Code' => $schedule->subject->subject_code,
                    'Subject Name' => $schedule->subject->subject_name,
                    'Instructor' => $schedule->instructor->full_name,
                    'Section' => $schedule->section->section_code,
                    'Room' => $schedule->room->room_number,
                    'Day' => $schedule->day_of_week,
                    'Start Time' => $schedule->start_time,
                    'End Time' => $schedule->end_time,
                    'Semester' => $schedule->semester,
                    'Academic Year' => $schedule->academic_year,
                    'Status' => $schedule->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Subject Code',
            'Subject Name',
            'Instructor',
            'Section',
            'Room',
            'Day',
            'Start Time',
            'End Time',
            'Semester',
            'Academic Year',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

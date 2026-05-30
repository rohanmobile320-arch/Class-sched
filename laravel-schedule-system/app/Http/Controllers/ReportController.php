<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SchedulesExport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('admin.reports.index');
    }

    public function schedulesByInstructor($instructorId)
    {
        $schedules = $this->reportService->getSchedulesByInstructor($instructorId);
        return view('admin.reports.instructor', compact('schedules'));
    }

    public function schedulesBySection($sectionId)
    {
        $schedules = $this->reportService->getSchedulesBySection($sectionId);
        return view('admin.reports.section', compact('schedules'));
    }

    public function schedulesByRoom($roomId)
    {
        $schedules = $this->reportService->getSchedulesByRoom($roomId);
        return view('admin.reports.room', compact('schedules'));
    }

    public function conflictReport()
    {
        $conflicts = $this->reportService->getConflictReport();
        return view('admin.reports.conflicts', compact('conflicts'));
    }

    public function instructorLoadReport()
    {
        $instructors = $this->reportService->getInstructorLoadReport();
        return view('admin.reports.instructor-load', compact('instructors'));
    }

    public function roomUtilizationReport()
    {
        $rooms = $this->reportService->getRoomUtilizationReport();
        return view('admin.reports.room-utilization', compact('rooms'));
    }

    public function exportSchedulesPdf()
    {
        $schedules = $this->reportService->getSchedulesBySection(null);
        $pdf = Pdf::loadView('admin.reports.schedules-pdf', compact('schedules'));
        return $pdf->download('schedules.pdf');
    }

    public function exportSchedulesExcel()
    {
        return Excel::download(new SchedulesExport, 'schedules.xlsx');
    }
}

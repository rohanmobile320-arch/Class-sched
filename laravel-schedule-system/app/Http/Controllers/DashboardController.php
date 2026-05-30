<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->middleware('auth');
        $this->reportService = $reportService;
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->studentDashboard();
        }
    }

    private function adminDashboard()
    {
        $statistics = $this->reportService->getTotalStatistics();
        
        // Get upcoming schedules
        $upcomingSchedules = Schedule::where('status', 'active')
            ->with('subject', 'instructor', 'section', 'room')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->limit(10)
            ->get();

        // Get schedule distribution by day
        $schedulesByDay = Schedule::selectRaw('day_of_week, COUNT(*) as count')
            ->where('status', 'active')
            ->groupBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $dayData = [];
        foreach ($daysOfWeek as $day) {
            $dayData[$day] = $schedulesByDay[$day]->count ?? 0;
        }

        return view('admin.dashboard', compact('statistics', 'upcomingSchedules', 'dayData'));
    }

    private function studentDashboard()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return view('student.dashboard', ['schedules' => []]);
        }

        $schedules = $student->getClassSchedules();

        return view('student.dashboard', compact('schedules'));
    }
}

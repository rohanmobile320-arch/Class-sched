<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student routes
    Route::get('/my-schedule', [ScheduleController::class, 'mySchedule'])->name('my-schedule');

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Subjects
        Route::resource('subjects', SubjectController::class);

        // Sections
        Route::resource('sections', SectionController::class);

        // Rooms
        Route::resource('rooms', RoomController::class);

        // Instructors
        Route::resource('instructors', InstructorController::class);

        // Students
        Route::resource('students', StudentController::class);

        // Schedules
        Route::resource('schedules', ScheduleController::class);

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/conflicts', [ReportController::class, 'conflictReport'])->name('reports.conflicts');
        Route::get('/reports/instructor-load', [ReportController::class, 'instructorLoadReport'])->name('reports.instructor-load');
        Route::get('/reports/room-utilization', [ReportController::class, 'roomUtilizationReport'])->name('reports.room-utilization');
        Route::get('/reports/export-pdf', [ReportController::class, 'exportSchedulesPdf'])->name('reports.export-pdf');
        Route::get('/reports/export-excel', [ReportController::class, 'exportSchedulesExcel'])->name('reports.export-excel');
    });
});

require __DIR__.'/auth.php';

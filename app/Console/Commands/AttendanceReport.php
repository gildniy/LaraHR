<?php

namespace LaraHR\Console\Commands;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Console\Command as BaseCommand;
use LaraHR\Exports\AttendanceExport;
use LaraHR\Models\Attendance;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceReport extends BaseCommand
{
    protected $signature = 'attendance:report';
    protected $description = 'Generate attendance report';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = Carbon::today()->toDateString();
        $attendances = Attendance::whereDate('created_at', $date)->get();

        // Generate PDF
        $pdf = PDF::loadView('reports.attendance', ['attendances' => $attendances]);
        $pdf->save(storage_path('app/public/reports/attendance_' . $date . '.pdf'));

        $data = $attendances->map(function ($attendance) {
            return [
                'names' => $attendance->employee->names,
                'check_in' => $attendance->check_in,
                'check_out' => $attendance->check_out,
            ];
        });

        // Generate Excel
        Excel::store(new AttendanceExport($data), 'public/reports/attendance_' . $date . '.xlsx');
    }
}

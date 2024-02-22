<?php

namespace LaraHR\Jobs;

use LaraHR\Models\Employee;
use LaraHR\Models\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use LaraHR\Mail\AttendanceRecorded;

class SendAttendanceRecordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Employee $employee;
    protected Attendance $attendance;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Employee $employee, Attendance $attendance)
    {
        $this->employee = $employee;
        $this->attendance = $attendance;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->employee->email)->send(new AttendanceRecorded($this->attendance));
    }
}

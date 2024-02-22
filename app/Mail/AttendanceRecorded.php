<?php

namespace LaraHR\Mail;

use LaraHR\Models\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use LaraHR\Models\Employee;

class AttendanceRecorded extends Mailable
{
    use Queueable, SerializesModels;

    protected $attendance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.attendance-recorded')
            ->with(['attendance' => $this->attendance]);
    }
}

<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use LaraHR\Mail\AttendanceRecorded;
use LaraHR\Models\Employee;
use LaraHR\Models\User;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function testEmployeeCanRecordAttendance()
    {
        // Mock the Mail facade to assert that the correct email is sent
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        // Record check-in
        $response = $this->postJson('/api/attendance/checkin', [
            'employee_id' => $employee->id,
            'check_in' => Carbon::now()->toDateTimeString(),
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Employee checkin recorded successfully']);

        // Assert that an email was sent for check-in
        Mail::assertSent(AttendanceRecorded::class, function (AttendanceRecorded $mail) use ($user, $employee) {
            return $mail->hasTo($employee->email) ;
        });

        // Record check-out
        $response = $this->postJson('/api/attendance/checkout', [
            'employee_id' => $employee->id,
            'check_out' => Carbon::now()->toDateTimeString(),
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Employee checkout recorded successfully']);
    }
}

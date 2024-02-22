<?php

namespace LaraHR\Http\Controllers\API;

use LaraHR\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaraHR\Jobs\SendAttendanceRecordEmail;
use LaraHR\Models\Attendance;
use Carbon\Carbon;
use LaraHR\Models\Employee;

class AttendanceController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/attendance/checkin",
     *     summary="Record employee checkin",
     *     tags={"Attendance"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"check_in", "employee_id"},
     *             @OA\Property(property="employee_id", type="int"),
     *             @OA\Property(property="check_in", type="string", format="date-time"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee checkin recorded successfully",
     *     )
     * )
     */
    public function recordCheckin(Request $request)
    {
        echo $request->employee_id;

        $request->validate([
            'employee_id' => 'required|numeric',
            'check_in' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Check if the employee already was checked in record for today
        $attendance = Attendance::where('employee_id', $request->employee_id)
            ->whereDate('check_in', Carbon::today())
            ->first();

        if ($attendance) {
            return response()->json(['message' => 'Checkin already recorded for today'], 400);
        }

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'check_in' => $request->check_in,
        ]);

        $employee = Employee::find($request->employee_id);

        SendAttendanceRecordEmail::dispatch($employee, $attendance)->onQueue('emails');

        return response()->json(['message' => 'Employee checkin recorded successfully'], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/attendance/checkout",
     *     summary="Record employee checkout",
     *     tags={"Attendance"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"check_out", "employee_id"},
     *             @OA\Property(property="employee_id", type="int"),
     *             @OA\Property(property="check_out", type="string", format="date-time"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee checkout recorded successfully",
     *     )
     * )
     */
    public function recordCheckout(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric',
            'check_out' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Find today's attendance record for the employee
        $attendance = Attendance::where('employee_id', $request->employee_id)
            ->whereDate('check_in', Carbon::today())
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'Checkin not found for today'], 404);
        }

        if ($attendance->check_out) {
            return response()->json(['message' => 'Checkout already recorded for today'], 400);
        }

        $attendance->update([
            'check_out' => $request->check_out,
        ]);

        return response()->json(['message' => 'Employee checkout recorded successfully'], 201);
    }
}

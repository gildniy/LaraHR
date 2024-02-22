<?php

namespace LaraHR\Http\Controllers\API;

use LaraHR\Http\Controllers\Controller;
use LaraHR\Models\Employee;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Employee",
 *     required={"id", "names", "email", "employeeIdentifier", "phoneNumber", "created_at", "updated_at"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="names", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="employeeIdentifier", type="string", example="EMP001"),
 *     @OA\Property(property="phoneNumber", type="string", example="123456789"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class EmployeeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/employees",
     *     summary="List all employees",
     *     tags={"Employee"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Employee"),
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $employees = Employee::paginate(10);
        return response()->json($employees);
    }

    /**
     * @OA\Post(
     *     path="/api/employees",
     *     summary="Create a new employee",
     *     tags={"Employee"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"names", "email", "employeeIdentifier", "phoneNumber"},
     *             @OA\Property(property="names", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="employeeIdentifier", type="string"),
     *             @OA\Property(property="phoneNumber", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee created successfully",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|string',
            'email' => 'required|email|unique:employees',
            'employeeIdentifier' => 'required|string|unique:employees',
            'phoneNumber' => 'required|string',
        ]);

        $employee = Employee::create([
            'names' => $request->names,
            'email' => $request->email,
            'employeeIdentifier' => $request->employeeIdentifier,
            'phoneNumber' => $request->phoneNumber,
        ]);

        return response()->json(['message' => 'Employee created successfully'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     summary="Get employee by ID",
     *     tags={"Employee"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee details retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *     )
     * )
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     summary="Update employee",
     *     tags={"Employee"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"names", "email", "employeeIdentifier", "phoneNumber"},
     *             @OA\Property(property="names", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="employeeIdentifier", type="string"),
     *             @OA\Property(property="phoneNumber", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee updated successfully",
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $request->validate([
            'names' => 'required|string',
            'email' => 'required|email|unique:employees,email,'.$id,
            'employeeIdentifier' => 'required|string|unique:employees,employeeIdentifier,'.$id,
            'phoneNumber' => 'required|string',
        ]);

        $employee->update([
            'names' => $request->names,
            'email' => $request->email,
            'employeeIdentifier' => $request->employeeIdentifier,
            'phoneNumber' => $request->phoneNumber,
        ]);

        return response()->json(['message' => 'Employee updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/employees/{id}",
     *     summary="Delete employee",
     *     tags={"Employee"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *     )
     * )
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
}

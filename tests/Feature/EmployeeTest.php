<?php

namespace Tests\Unit;

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaraHR\Models\Employee;
use LaraHR\Models\User;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanListEmployees()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/employees');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'names',
                        'email',
                        'employeeIdentifier',
                        'phoneNumber',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'total',
                'per_page',
                'next_page_url',
                'prev_page_url',
                'last_page',
            ]);
    }

    public function testEmployeeCanBeCreated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/employees', [
            'names' => 'John Doe',
            'email' => 'john@example.com',
            'employeeIdentifier' => 'EMP001',
            'phoneNumber' => '123456789',
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Employee created successfully']);
    }

    public function testEmployeeCanBeShown()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $response = $this->getJson("/api/employees/{$employee->id}");

        $response->assertStatus(200)
            ->assertJson($employee->toArray());
    }

    public function testEmployeeCanBeUpdated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $response = $this->putJson("/api/employees/{$employee->id}", [
            'names' => 'Updated Names',
            'email' => 'updated@example.com',
            'employeeIdentifier' => 'EMP002',
            'phoneNumber' => '987654321',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Employee updated successfully']);
    }

    public function testEmployeeCanBeDeleted()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Employee deleted successfully']);
    }
}

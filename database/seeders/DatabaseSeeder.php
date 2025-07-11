<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 Departments
        Department::factory(10)->create();

        // Create 100,000 Employees with Employee Details
        Employee::factory(100000)
            ->create()
            ->each(function ($employee) {
                $employee->detail()->create(
                    \Database\Factories\EmployeeDetailFactory::new()->make()->toArray()
                );
            });

        // Optional: Remove test user if you don’t need it
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

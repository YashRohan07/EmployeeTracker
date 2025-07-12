<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeCount = Employee::count();
        $departmentCount = Department::count();

        // Get recent 5 employees with department and detail (salary, joining date)
        $recentEmployees = Employee::with(['department', 'detail'])
            ->orderByDesc('created_at') // Or orderByDesc('detail.joined_date') if you want
            ->limit(5)
            ->get();

        return inertia('Dashboard', [
            'employeeCount'   => $employeeCount,
            'departmentCount' => $departmentCount,
            'recentEmployees' => $recentEmployees,
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    // ✅ Display a list of employees with search, filter, sort, pagination
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'detail']);

        // 🔍 Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // ✅ Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // ✅ Filter by salary range
        if ($request->filled('salary_min')) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('salary', '>=', $request->salary_min);
            });
        }

        if ($request->filled('salary_max')) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('salary', '<=', $request->salary_max);
            });
        }

        // ✅ Filter by joining date range
        if ($request->filled('joining_date_from')) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('joined_date', '>=', $request->joining_date_from);
            });
        }

        if ($request->filled('joining_date_to')) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('joined_date', '<=', $request->joining_date_to);
            });
        }

        // ✅ Safe sort by joined_date of employee_details using subquery
        if (in_array(strtolower($request->sort), ['asc', 'desc'])) {
            $query->orderBy(
                DB::raw('(select joined_date from employee_details where employee_details.employee_id = employees.id)'),
                $request->sort
            );
        } else {
            $query->orderBy('name');
        }

        // ✅ Paginate with query string
        return response()->json(
            $query->paginate(50)->appends($request->query())
        );
    }

    // ✅ Store a newly created employee
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'designation'   => 'required|string|max:255',
            'salary'        => 'required|numeric',
            'address'       => 'required|string',
            'joined_date'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee = Employee::create([
            'id'            => Str::uuid(),
            'name'          => $request->name,
            'email'         => $request->email,
            'department_id' => $request->department_id,
        ]);

        $employee->detail()->create([
            'designation' => $request->designation,
            'salary'      => $request->salary,
            'address'     => $request->address,
            'joined_date' => $request->joined_date,
        ]);

        return response()->json([
            'message'  => 'Employee created successfully!',
            'employee' => $employee->load('detail')
        ], 201);
    }

    // ✅ Display specified employee
    public function show(string $id)
    {
        $employee = Employee::with(['department', 'detail'])->find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        return response()->json($employee);
    }

    // ✅ Update specified employee
    public function update(Request $request, string $id)
    {
        $employee = Employee::with('detail')->find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'sometimes|required|string|max:255',
            'email'         => 'sometimes|required|email|unique:employees,email,' . $id,
            'department_id' => 'sometimes|required|exists:departments,id',
            'designation'   => 'sometimes|required|string|max:255',
            'salary'        => 'sometimes|required|numeric',
            'address'       => 'sometimes|required|string',
            'joined_date'   => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee->update($request->only(['name', 'email', 'department_id']));

        if ($employee->detail) {
            $employee->detail->update($request->only(['designation', 'salary', 'address', 'joined_date']));
        }

        return response()->json([
            'message'  => 'Employee updated successfully!',
            'employee' => $employee->load('detail')
        ]);
    }

    // ✅ Delete specified employee
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{

    // Display a list of the employees.
    
    public function index()
    {
        $employees = Employee::with(['department', 'detail'])->paginate(50);
        return response()->json($employees);
    }

    
    //Store a newly created employee in the database.

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

        return response()->json(['message' => 'Employee created successfully!', 'employee' => $employee->load('detail')], 201);
    }

    
    // Display the specified employee

    public function show(string $id)
    {
        $employee = Employee::with(['department', 'detail'])->find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        return response()->json($employee);
    }

    
    // Update the specified employee in the database

    public function update(Request $request, string $id)
    {
        $employee = Employee::with('detail')->find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'sometimes|required|string|max:255',
            'email'         => 'sometimes|required|email|unique:employees,email,' . $id . ',id',
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

        return response()->json(['message' => 'Employee updated successfully!', 'employee' => $employee->load('detail')]);
    }


    // Remove the specified employee from the database

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

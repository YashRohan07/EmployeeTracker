<?php

use App\Http\Controllers\ProfileController;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Default welcome page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ✅ Dashboard route — now handles ALL employees with filters too
Route::get('/dashboard', function (Request $request) {
    $employeeCount = Employee::count();
    $departmentCount = Department::count();

    $recentEmployees = Employee::with(['department', 'detail'])
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

    $query = Employee::with(['department', 'detail']);

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }

    if ($request->filled('department_id')) {
        $query->where('department_id', $request->department_id);
    }

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

    if (in_array($request->sort, ['asc', 'desc'])) {
        $query->orderBy(
            \DB::raw('(select joined_date from employee_details where employee_details.employee_id = employees.id)'),
            $request->sort
        );
    } else {
        $query->orderBy('name');
    }

    $allEmployees = $query->paginate(10)->appends($request->query());

    return Inertia::render('Dashboard', [
        'employeeCount'   => $employeeCount,
        'departmentCount' => $departmentCount,
        'recentEmployees' => $recentEmployees,
        'allEmployees'    => $allEmployees,
        'departments'     => Department::all(),
        'filters'         => $request->only([
            'search', 'department_id', 'salary_min', 'salary_max',
            'joining_date_from', 'joining_date_to', 'sort'
        ]),
        'auth' => [
            'user' => Auth::user(),
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ REMOVE EmployeeIndex — not needed
// ✅ Keep create/edit if you still use them:
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/employees/create', function () {
        return Inertia::render('EmployeeForm');
    })->name('employees.create');

    Route::get('/employees/{employee}/edit', function ($id) {
        $employee = Employee::with(['department', 'detail'])->findOrFail($id);
        return Inertia::render('EmployeeForm', [
            'employee' => $employee
        ]);
    })->name('employees.edit');
});

require __DIR__.'/auth.php';

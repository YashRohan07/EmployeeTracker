<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmployeeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Remove `index` — now handled by web route
Route::middleware('auth:sanctum')->apiResource('employees', EmployeeController::class)->except(['index']);

Route::middleware('auth:sanctum')->get('/departments', function () {
    return response()->json(\App\Models\Department::all());
});

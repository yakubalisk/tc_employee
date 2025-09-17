<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Employee routes
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/export', [EmployeeController::class, 'export'])->name('employees.export');
Route::get('/employees/{employee}/export', [EmployeeController::class, 'exportSingle'])->name('employees.export.single');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

// Quick action routes
Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
Route::get('/promotions/process', [PromotionController::class, 'process'])->name('promotions.process');
Route::get('/transfers/schedule', [TransferController::class, 'schedule'])->name('transfers.schedule');
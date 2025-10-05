<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\AparGradingController;
use App\Http\Controllers\FinancialUpgradationController;

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

Route::get('/export', [ExportController::class, 'index'])->name('export.index');
Route::post('/export', [ExportController::class, 'export'])->name('export.process');
Route::post('/export/email', [ExportController::class, 'emailReport'])->name('export.email');
Route::post('/export/schedule', [ExportController::class, 'scheduleExport'])->name('export.schedule');


// Promotion routes
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
Route::get('/promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
Route::get('/promotions/{promotion}', [PromotionController::class, 'show'])->name('promotions.show');
Route::post('/promotions/{promotion}/approve', [PromotionController::class, 'approve'])->name('promotions.approve');
Route::post('/promotions/{promotion}/reject', [PromotionController::class, 'reject'])->name('promotions.reject');
Route::get('/promotions/report', [PromotionController::class, 'report'])->name('promotions.report');


Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

// Separate APAR Module Routes
Route::prefix('apar')->name('apar.')->group(function () {
    Route::get('/import', [AparGradingController::class, 'import'])->name('import');
    Route::post('/import', [AparGradingController::class, 'processImport'])->name('process-import');
    Route::get('/template', [AparGradingController::class, 'exportTemplate'])->name('export-template');
    Route::get('/export', [AparGradingController::class, 'export'])->name('export');
    Route::get('/', [AparGradingController::class, 'index'])->name('index');
    Route::get('/create', [AparGradingController::class, 'create'])->name('create');
    Route::post('/', [AparGradingController::class, 'store'])->name('store');
    Route::get('/{aparGrading}', [AparGradingController::class, 'show'])->name('show');
    Route::get('/{aparGrading}/edit', [AparGradingController::class, 'edit'])->name('edit');
    Route::put('/{aparGrading}', [AparGradingController::class, 'update'])->name('update');
    Route::delete('/{aparGrading}', [AparGradingController::class, 'destroy'])->name('destroy');
});

Route::get('financial-upgradation/export', [FinancialUpgradationController::class, 'export'])->name('financial-upgradation.export');
Route::get('financial-upgradation/import', [FinancialUpgradationController::class, 'importForm'])->name('financial-upgradation.import.form');
Route::post('financial-upgradation/import', [FinancialUpgradationController::class, 'import'])->name('financial-upgradation.import');
Route::get('financial-upgradation/template', [FinancialUpgradationController::class, 'downloadTemplate'])->name('financial-upgradation.template');
Route::resource('financial-upgradation', FinancialUpgradationController::class);


// Transfer routes
Route::get('/transfers', [TransferController::class, 'index'])->name('transfers.index');
Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');
Route::get('/transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');
Route::post('/transfers/{transfer}/approve', [TransferController::class, 'approve'])->name('transfers.approve');
Route::post('/transfers/{transfer}/complete', [TransferController::class, 'complete'])->name('transfers.complete');
Route::post('/transfers/{transfer}/reject', [TransferController::class, 'reject'])->name('transfers.reject');
Route::get('/api/location-distribution', [TransferController::class, 'getLocationDistribution'])->name('transfers.location-distribution');
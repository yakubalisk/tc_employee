<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedReport = $request->get('report', 'employee-summary');
        $filterDepartment = $request->get('department', 'all');
        $filterDateRange = $request->get('date_range', 'current-year');
        $customFilter = $request->get('custom_filter', '');

        $reportTypes = [
            ['id' => 'employee-summary', 'name' => 'Employee Summary Report', 'icon' => 'users-icon'],
            ['id' => 'promotion-report', 'name' => 'Promotion Report', 'icon' => 'trending-up-icon'],
            ['id' => 'transfer-report', 'name' => 'Transfer Report', 'icon' => 'calendar-icon'],
            ['id' => 'department-wise', 'name' => 'Department Wise Report', 'icon' => 'building-icon'],
            ['id' => 'retirement-due', 'name' => 'Retirement Due Report', 'icon' => 'award-icon'],
            ['id' => 'age-analysis', 'name' => 'Age Analysis Report', 'icon' => 'users-icon'],
        ];

        $reportData = $this->generateReportData($selectedReport, $filterDepartment, $filterDateRange, $customFilter);

        return view('reports.index', compact(
            'selectedReport',
            'filterDepartment',
            'filterDateRange',
            'customFilter',
            'reportTypes',
            'reportData'
        ));
    }

    private function generateReportData($reportType, $department, $dateRange, $customFilter)
    {
        switch ($reportType) {
            case 'employee-summary':
                return $this->getEmployeeSummaryData($department);
                
            case 'promotion-report':
                return $this->getPromotionData($dateRange);
                
            case 'retirement-due':
                return $this->getRetirementData();
                
            case 'department-wise':
                return $this->getDepartmentWiseData();
                
            case 'age-analysis':
                return $this->getAgeAnalysisData();
                
            default:
                return [];
        }
    }

    private function getEmployeeSummaryData($department)
    {
        $query = Employee::query();
        
        if ($department !== 'all') {
            $query->where('presentPosting', $department);
        }

        $employees = $query->get();
        $totalEmployees = $employees->count();
        
        $maleCount = $employees->where('gender', 'MALE')->count();
        $femaleCount = $employees->where('gender', 'FEMALE')->count();
        $otherCount = $employees->where('gender', 'OTHER')->count();
        
        $averageAge = $employees->avg('age');
        
        $categoryDistribution = $employees->groupBy('category')
            ->map->count()
            ->sortDesc();

        return [
            'totalEmployees' => $totalEmployees,
            'maleCount' => $maleCount,
            'femaleCount' => $femaleCount,
            'otherCount' => $otherCount,
            'averageAge' => round($averageAge),
            'categoryDistribution' => $categoryDistribution
        ];
    }

    private function getPromotionData($dateRange)
    {
        $query = Promotion::with('employee')->approved();
        
        // Apply date range filter
        switch ($dateRange) {
            case 'current-year':
                $query->whereYear('effective_date', now()->year);
                break;
            case 'last-year':
                $query->whereYear('effective_date', now()->subYear()->year);
                break;
            case 'last-5-years':
                $query->where('effective_date', '>=', now()->subYears(5));
                break;
        }

        $promotedEmployees = $query->get();
        $promotedThisYear = Promotion::approved()->whereYear('effective_date', now()->year)->count();
        
        // Get employees eligible for promotion (not promoted in last year)
        $pendingPromotions = Employee::whereDoesntHave('promotions', function ($q) {
            $q->where('approval_status', 'Approved')
              ->where('effective_date', '>=', now()->subYear());
        })->where('status', 'EXISTING')->count();

        return [
            'promotedThisYear' => $promotedThisYear,
            'pendingPromotions' => $pendingPromotions,
            'promotedEmployees' => $promotedEmployees->take(10)
        ];
    }

    private function getRetirementData()
    {
        $retiringSoon = Employee::where('status', 'EXISTING')
            ->where('dateOfRetirement', '<=', now()->addYears(2))
            ->orderBy('dateOfRetirement')
            ->get();

        return [
            'retiringSoon' => $retiringSoon
        ];
    }

    private function getDepartmentWiseData()
    {
        return Employee::select('presentPosting as department', DB::raw('COUNT(*) as count'))
            ->groupBy('presentPosting')
            ->orderBy('count', 'desc')
            ->get();
    }

    private function getAgeAnalysisData()
    {
        $ageGroups = [
            '20-30' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) BETWEEN 20 AND 30')->count(),
            '31-40' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) BETWEEN 31 AND 40')->count(),
            '41-50' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) BETWEEN 41 AND 50')->count(),
            '51-60' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) BETWEEN 51 AND 60')->count(),
            '60+' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) > 60')->count(),
        ];

        return [
            'ageGroups' => $ageGroups,
            'averageAge' => round(Employee::avg(DB::raw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE())'))),
            'minAge' => Employee::min(DB::raw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE())')),
            'maxAge' => Employee::max(DB::raw('TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE())'))
        ];
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'pdf');
        $reportType = $request->get('report_type');
        $filters = $request->only(['department', 'date_range', 'custom_filter']);

        $data = $this->generateReportData($reportType, $filters['department'], $filters['date_range'], $filters['custom_filter']);

        if ($type === 'excel') {
            return $this->exportExcel($reportType, $data);
        }

        return $this->exportPDF($reportType, $data);
    }

    private function exportExcel($reportType, $data)
    {
        // Implement Excel export using Maatwebsite/Excel
        $fileName = str_replace(' ', '_', $reportType) . '_' . now()->format('Y_m_d') . '.xlsx';
        
        // You would use Maatwebsite/Excel here
        // return Excel::download(new ReportExport($data, $reportType), $fileName);
        
        return response()->json(['message' => 'Excel export would be implemented here']);
    }

    private function exportPDF($reportType, $data)
    {
        // Implement PDF export using DomPDF
        $fileName = str_replace(' ', '_', $reportType) . '_' . now()->format('Y_m_d') . '.pdf';
        
        // You would use DomPDF here
        // $pdf = PDF::loadView('reports.pdf.' . str_replace('-', '_', $reportType), $data);
        // return $pdf->download($fileName);
        
        return response()->json(['message' => 'PDF export would be implemented here']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate stats from database
        $totalEmployees = Employee::count();
        
        $averageAge = Employee::whereNotNull('dateOfBirth')
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE())) as average_age')
            ->value('average_age');
        $averageAge = $averageAge ? round($averageAge) : 0;

        $genderDistribution = Employee::select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [strtolower($item->gender) => $item->count];
            });

        $recentPromotions = Employee::where('promoted', true)->count();

        $retirementsDueInYear = Employee::whereYear('dateOfRetirement', now()->year)
            ->where('status', 'EXISTING')
            ->count();

        $stats = [
            'totalEmployees' => $totalEmployees,
            'averageAge' => $averageAge,
            'genderDistribution' => [
                'male' => $genderDistribution['male'] ?? 0,
                'female' => $genderDistribution['female'] ?? 0,
                'other' => $genderDistribution['other'] ?? 0,
            ],
            'recentPromotions' => $recentPromotions,
            'retirementsDueInYear' => $retirementsDueInYear,
        ];

        $quickStats = [
            [
                'title' => 'Total Employees',
                'value' => $stats['totalEmployees'],
                'icon' => 'users-icon',
                'color' => 'text-blue-600',
                'bgColor' => 'bg-blue-50',
            ],
            [
                'title' => 'Average Age',
                'value' => $stats['averageAge'] . ' years',
                'icon' => 'calendar-icon',
                'color' => 'text-green-600',
                'bgColor' => 'bg-green-50',
            ],
            [
                'title' => 'Recent Promotions',
                'value' => $stats['recentPromotions'],
                'icon' => 'trending-up-icon',
                'color' => 'text-purple-600',
                'bgColor' => 'bg-purple-50',
            ],
            [
                'title' => 'Retirements Due',
                'value' => $stats['retirementsDueInYear'],
                'icon' => 'award-icon',
                'color' => 'text-orange-600',
                'bgColor' => 'bg-orange-50',
            ],
        ];

        $recentEmployees = Employee::latest()->take(3)->get();

        return view('dashboard', compact('stats', 'quickStats', 'recentEmployees'));
    }
}
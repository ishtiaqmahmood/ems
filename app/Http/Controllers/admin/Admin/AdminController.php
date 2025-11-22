<?php

namespace App\Http\Controllers\admin\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Main Counters
        $employers      = \App\Models\Employer::count();
        $departments    = \App\Models\Department::count();
        $sections       = \App\Models\Section::count();
        $organizations  = \App\Models\Organization::count();
        $salaries       = \App\Models\EmployerSalary::count();
        $documents      = \App\Models\Documents::count();

        // === Analytics ===

        // 1. Employer Growth (Last 12 months)
        $monthlyGrowth = \App\Models\Employer::selectRaw('COUNT(id) as total, DATE_FORMAT(created_at, "%b %Y") as month')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->take(12)
            ->get();

        // 2. Department-wise Employees
        $deptStats = \App\Models\Department::withCount('employees')->get();

        // 3. Section-wise Employees
        $sectionStats = \App\Models\Section::withCount('employees')
            ->get()
            ->map(function ($section) {
                return [
                    'name' => $section->name,
                    'employees_count' => $section->employees_count ?? 0
                ];
            });

        return view('adminindex', compact(
            'employers',
            'departments',
            'sections',
            'organizations',
            'salaries',
            'documents',
            'monthlyGrowth',
            'deptStats',
            'sectionStats'
        ));
    }
}

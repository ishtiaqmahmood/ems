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
        // Detect database driver for compatibility (SQLite vs MySQL)
        $driver = config('database.default');
        $dateFormat = ($driver === 'sqlite')
            ? 'strftime("%Y-%m", created_at)'
            : 'DATE_FORMAT(created_at, "%Y-%m")';

        $monthlyGrowth = \App\Models\Employer::selectRaw("COUNT(id) as total, $dateFormat as month")
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->take(12)
            ->get()
            ->map(function ($item) {
                $item->month = \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('M Y');
                return $item;
            });

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

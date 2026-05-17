<?php

namespace App\Http\Controllers\Admin\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryGrade;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of salary grades.
     */
    public function index()
    {
        $grades = SalaryGrade::ordered()->paginate(20);
        return view('admin.salary_grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new salary grade.
     */
    public function create()
    {
        return view('admin.salary_grades.create');
    }

    /**
     * Store a new salary grade.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                 => 'required|string|unique:salary_grades,name',
            'level'                => 'required|integer|unique:salary_grades,level',
            'basic_salary'         => 'required|numeric|min:0',
            'house_rent'           => 'nullable|numeric|min:0',
            'transport_allowance'  => 'nullable|numeric|min:0',
            'medical_allowance'    => 'nullable|numeric|min:0',
            'other_allowances'     => 'nullable|numeric|min:0',
        ]);

        SalaryGrade::create($data);

        return redirect()->route('admin.salary-grades.index')
            ->with('success', 'Salary grade created successfully.');
    }

    /**
     * Show the form for editing a salary grade.
     */
    public function edit(SalaryGrade $salaryGrade)
    {
        return view('admin.salary_grades.edit', compact('salaryGrade'));
    }

    /**
     * Update salary grade.
     */
    public function update(Request $request, SalaryGrade $salaryGrade)
    {
        $data = $request->validate([
            'name'                 => 'required|string|unique:salary_grades,name,' . $salaryGrade->id,
            'level'                => 'required|integer|unique:salary_grades,level,' . $salaryGrade->id,
            'basic_salary'         => 'required|numeric|min:0',
            'house_rent'           => 'nullable|numeric|min:0',
            'transport_allowance'  => 'nullable|numeric|min:0',
            'medical_allowance'    => 'nullable|numeric|min:0',
            'other_allowances'     => 'nullable|numeric|min:0',
        ]);

        $salaryGrade->update($data);

        return redirect()->route('admin.salary-grades.index')
            ->with('success', 'Salary grade updated successfully.');
    }

    /**
     * Delete a salary grade.
     */
    public function destroy(SalaryGrade $salaryGrade)
    {
        $salaryGrade->delete();

        return redirect()->route('admin.salary-grades.index')
            ->with('success', 'Salary grade deleted successfully.');
    }
}

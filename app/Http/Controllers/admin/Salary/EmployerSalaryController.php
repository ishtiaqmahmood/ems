<?php

namespace App\Http\Controllers\admin\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\EmployerSalary;
use App\Models\SalaryGrade;
use App\Models\SalaryHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployerSalaryController extends Controller
{
    public function all(Request $request)
    {
        $query = EmployerSalary::with(['employer', 'grade']);

        // Search
        if ($request->search) {
            $query->whereHas('employer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Employer
        if ($request->employer) {
            $query->where('employer_id', $request->employer);
        }

        // Filter Grade
        if ($request->grade) {
            $query->where('salary_grade_id', $request->grade);
        }

        // Filter Date
        if ($request->date) {
            $query->whereDate('effective_from', $request->date);
        }

        $salaries = $query->paginate(20);

        return view('admin.salaries.all', [
            'salaries'     => $salaries,
            'allEmployers' => \App\Models\Employer::select('id', 'name')->get(),
            'allGrades'    => \App\Models\SalaryGrade::select('id', 'name')->orderBy('level')->get(),
        ]);
    }

    /**
     * List salaries for an employer.
     */
    public function index(Employer $employer)
    {
        $salaries = $employer->salaryHistories()->latest()->paginate(20);

        return view('admin.salaries.index', compact('employer', 'salaries'));
    }

    /**
     * Show salary create form.
     */
    public function create(\App\Models\Employer $employer)
    {
        // $employer is automatically resolved via Route Model Binding
        $grades = \App\Models\SalaryGrade::orderBy('level')->get();

        return view('admin.salaries.create', compact('employer', 'grades'));
    }
    /**
     * Store new salary for employer.
     */
    public function store(Request $request, Employer $employer)
    {
        $data = $request->validate([
            'salary_grade_id'      => 'nullable|exists:salary_grades,id',
            'basic_salary'         => 'required|numeric|min:0',
            'house_rent'           => 'nullable|numeric|min:0',
            'transport_allowance'  => 'nullable|numeric|min:0',
            'medical_allowance'    => 'nullable|numeric|min:0',
            'other_allowances'     => 'nullable|numeric|min:0',
            'effective_from'       => 'required|date',
            'change_reason'        => 'required|string',
        ]);

        $activeSalary = EmployerSalary::where('employer_id', $employer->id)
            ->whereNull('effective_to')
            ->first();

        if ($activeSalary) {
            return back()->withErrors([
                'error' => 'An active salary already exists for this employer. You can edit or delete it first.'
            ]);
        }

        $data['gross_salary'] =
            $data['basic_salary']
            + ($data['house_rent'] ?? 0)
            + ($data['transport_allowance'] ?? 0)
            + ($data['medical_allowance'] ?? 0)
            + ($data['other_allowances'] ?? 0);

        EmployerSalary::create([
            'employer_id'         => $employer->id,
            'salary_grade_id'     => $data['salary_grade_id'],
            'basic_salary'        => $data['basic_salary'],
            'house_rent'          => $data['house_rent'],
            'transport_allowance' => $data['transport_allowance'],
            'medical_allowance'   => $data['medical_allowance'],
            'other_allowances'    => $data['other_allowances'],
            'gross_salary'        => $data['gross_salary'],
            'effective_from'      => $data['effective_from'],
        ]);

        // Log history
        SalaryHistory::create([
            'employer_id'      => $employer->id,
            'salary_grade_id'  => $data['salary_grade_id'],
            'basic_salary'     => $data['basic_salary'],
            'gross_salary'     => $data['gross_salary'],
            'change_reason'    => $data['change_reason'],
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('admin.salaries.all')
            ->with('success', 'Salary created successfully.');
    }
    /**
     * Show salary edit form.
     */
    public function edit(Employer $employer, EmployerSalary $salary)
    {
        $grades = SalaryGrade::orderBy('level')->get();

        return view('admin.salaries.edit', compact('employer', 'salary', 'grades'));
    }

    /**
     * Update salary for employer.
     */
    public function update(Request $request, Employer $employer, EmployerSalary $salary)
    {
        $data = $request->validate([
            'salary_grade_id'      => 'nullable|exists:salary_grades,id',
            'basic_salary'         => 'required|numeric|min:0',
            'house_rent'           => 'nullable|numeric|min:0',
            'transport_allowance'  => 'nullable|numeric|min:0',
            'medical_allowance'    => 'nullable|numeric|min:0',
            'other_allowances'     => 'nullable|numeric|min:0',
            'effective_from'       => 'required|date',
            'change_reason'        => 'required|string',
        ]);

        $data['gross_salary'] =
            $data['basic_salary']
            + ($data['house_rent'] ?? 0)
            + ($data['transport_allowance'] ?? 0)
            + ($data['medical_allowance'] ?? 0)
            + ($data['other_allowances'] ?? 0);

        $salary->update($data);

        // Log history
        SalaryHistory::create([
            'employer_id'      => $employer->id,
            'salary_grade_id'  => $data['salary_grade_id'],
            'basic_salary'     => $data['basic_salary'],
            'gross_salary'     => $data['gross_salary'],
            'change_reason'    => $data['change_reason'],
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('admin.salaries.all')
            ->with('success', 'Salary updated successfully.');
    }

    /**
     * Delete latest salary entry.
     */
    public function destroy(Employer $employer, EmployerSalary $salary)
    {
        $salary->delete();

        return back()->with('success', 'Salary record deleted.');
    }
}

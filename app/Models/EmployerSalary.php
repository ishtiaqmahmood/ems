<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployerSalary extends Model
{
    use HasFactory;

    protected $table = 'employer_salaries';

    protected $fillable = [
        'employer_id',
        'salary_grade_id',
        'basic_salary',
        'house_rent',
        'transport_allowance',
        'medical_allowance',
        'other_allowances',
        'gross_salary',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to'   => 'date',
    ];

    // Employer Relation
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    // Salary Grade Relation
    public function grade()
    {
        return $this->belongsTo(SalaryGrade::class, 'salary_grade_id');
    }

    // Scope: Get current active salary
    public function scopeCurrent($query)
    {
        return $query->whereNull('effective_to');
    }

    // Auto Calculate Gross Salary
    public function calculateGrossSalary()
    {
        return $this->basic_salary
            + $this->house_rent
            + $this->transport_allowance
            + $this->medical_allowance
            + $this->other_allowances;
    }
}

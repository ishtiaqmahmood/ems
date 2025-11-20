<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'basic_salary',
        'house_rent',
        'transport_allowance',
        'medical_allowance',
        'other_allowances',
    ];

    // Employers assigned to this grade (via employer_salaries)
    public function employerSalaries()
    {
        return $this->hasMany(EmployerSalary::class);
    }

    // Salary histories connected to this grade
    public function salaryHistories()
    {
        return $this->hasMany(SalaryHistory::class);
    }

    // Calculate total grade salary
    public function getGrossSalaryAttribute()
    {
        return $this->basic_salary
            + $this->house_rent
            + $this->transport_allowance
            + $this->medical_allowance
            + $this->other_allowances;
    }

    // Sort grades automatically by "level"
    public function scopeOrdered($query)
    {
        return $query->orderBy('level', 'asc');
    }
}

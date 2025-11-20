<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'salary_grade_id',
        'basic_salary',
        'gross_salary',
        'change_reason',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Employer relation
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    // Grade at time of salary change
    public function grade()
    {
        return $this->belongsTo(SalaryGrade::class, 'salary_grade_id');
    }

    // Admin who performed the salary update
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Human readable reason
    public function getReasonLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->change_reason));
    }
}

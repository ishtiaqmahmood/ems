<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name_bn',
        'name_en',
        'max_duration',
        'duration_unit',
        'requires_medical',
        'paid',
        'lifetime_limit',
        'description',
    ];

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'bn'
            ? $this->name_bn
            : $this->name_en;
    }
}

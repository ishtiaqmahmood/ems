<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'total_days',
        'type',
        'status',
        'reason',
    ];

    /**
     * Relationship: A vacation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optional: Calculate total_days automatically if needed.
     */
    public static function booted()
    {
        static::saving(function ($vacation) {
            if (!$vacation->total_days) {
                $vacation->total_days = $vacation->start_date->diffInDays($vacation->end_date) + 1;
            }
        });
    }
}

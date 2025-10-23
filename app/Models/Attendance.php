<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'total_hours',
        'total_days',
        'total_leaves',
        'total_absents',
    ];

    protected $casts = [
        'total_hours' => 'float',

    ];

    /**
     * Relationship: An attendance record belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total hours for this record based on check_in and check_out.
     */
    public function calculateTotalHours()
    {
        if ($this->check_in && $this->check_out) {
            // Parse times safely
            $checkIn = Carbon::parse($this->date . ' ' . substr($this->check_in, 0, 5));
            $checkOut = Carbon::parse($this->date . ' ' . substr($this->check_out, 0, 5));

            // Handle overnight shifts
            if ($checkOut->lessThan($checkIn)) {
                $checkOut->addDay();
            }

            // Calculate total hours as positive float
            $hours = $checkOut->floatDiffInHours($checkIn);
            $this->total_hours = round(abs($hours), 2);
        } else {
            $this->total_hours = null;
        }
    }

    /**
     * Accessor: Always return total_hours as positive float or null.
     */
    public function getTotalHoursAttribute($value)
    {
        return $value !== null ? round(abs((float) $value), 2) : null;
    }

    /**
     * Update cumulative totals (total_days, total_leaves, total_absents) for this user.
     */
    public function updateTotals()
    {
        $this->total_days = self::where('user_id', $this->user_id)
            ->where('date', '<=', $this->date)
            ->where('status', 'Present')
            ->count();

        $this->total_leaves = self::where('user_id', $this->user_id)
            ->where('date', '<=', $this->date)
            ->where('status', 'Leave')
            ->count();

        $this->total_absents = self::where('user_id', $this->user_id)
            ->where('date', '<=', $this->date)
            ->where('status', 'Absent')
            ->count();
    }

    /**
     * Save model and automatically calculate total_hours and cumulative totals.
     */
    public function saveWithCalculations(array $attributes = [])
    {
        $this->fill($attributes);
        $this->calculateTotalHours();
        $this->save();          // Save first to have ID for totals if needed
        $this->updateTotals();  // Update cumulative totals
        $this->save();          // Save totals
    }

    /**
     * Get total attendance count for a specific user in the current month.
     */
    public static function totalAttendanceThisMonth($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', 'Present')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
    }

    /**
     * Get total attendance count for a specific user in the current year.
     */
    public static function totalAttendanceThisYear($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', 'Present')
            ->whereYear('date', Carbon::now()->year)
            ->count();
    }

    /**
     * Get total attendance count for a specific user for all time.
     */
    public static function totalAttendanceAllTime($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', 'Present')
            ->count();
    }
}

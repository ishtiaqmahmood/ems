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
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            $this->total_hours = round($checkIn->floatDiffInHours($checkOut), 2);
            $this->save();
        }
    }

    /**
     * Update cumulative totals (total_days, total_leaves, total_absents) for this user up to this date.
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

        $this->save();
    }

    /**
     * Get total present days for a given month.
     */
    public static function monthlyCount($userId, $month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return self::where('user_id', $userId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('status', 'Present')
            ->count();
    }

    /**
     * Get total present days for a given year.
     */
    public static function yearlyCount($userId, $year = null)
    {
        $year = $year ?? now()->year;

        return self::where('user_id', $userId)
            ->whereYear('date', $year)
            ->where('status', 'Present')
            ->count();
    }
}

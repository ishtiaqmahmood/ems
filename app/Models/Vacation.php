<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Notifications\NewLeaveApplication;
use Illuminate\Support\Facades\Notification;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type_id',

        // Employee info (snapshot at time of leave)
        'mobile',
        'address',
        'nid_number',
        'salary',
        'designation',

        // Leave balance info
        'due_leave',
        'earned_leaves',
        'leaves_taken',

        // Replacement
        'replacement_user_id',

        // Leave dates
        'start_date',
        'end_date',
        'total_days',

        // Status & approval
        'status',
        'approved_by',
        'approved_at',

        // Documents & notes
        'medical_certificate',
        'letter_pdf',
        'reason',
        'description',
    ];

    protected $casts = [
        'start_date'   => 'date',
        'end_date'     => 'date',
        'approved_at'  => 'datetime',
        'salary'       => 'decimal:2',
    ];

    /* =======================
     | Relationships
     ======================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function replacementUser()
    {
        return $this->belongsTo(User::class, 'replacement_user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* =======================
     | Model Events
     ======================= */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vacation) {
            $vacation->total_days = self::computeDays(
                $vacation->start_date,
                $vacation->end_date
            );
        });

        static::created(function ($vacation) {
            $admins = User::where('role', 'Admin')->get();
            Notification::send($admins, new NewLeaveApplication($vacation));
        });

        static::updating(function ($vacation) {
            if ($vacation->isDirty(['start_date', 'end_date'])) {
                $vacation->total_days = self::computeDays(
                    $vacation->start_date,
                    $vacation->end_date
                );
            }

            // Remove old PDF if replaced
            if ($vacation->isDirty('letter_pdf')) {
                $old = $vacation->getOriginal('letter_pdf');
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
        });

        static::deleting(function ($vacation) {
            if ($vacation->letter_pdf && Storage::disk('public')->exists($vacation->letter_pdf)) {
                Storage::disk('public')->delete($vacation->letter_pdf);
            }
        });
    }

    /* =======================
     | Helpers & Accessors
     ======================= */

    private static function computeDays($start, $end): int
    {
        if (!$start || !$end) {
            return 0;
        }

        return Carbon::parse($start)
            ->diffInDays(Carbon::parse($end)) + 1; // inclusive
    }

    public function getLetterPdfUrlAttribute(): ?string
    {
        return $this->letter_pdf
            ? asset('storage/' . $this->letter_pdf)
            : null;
    }
}
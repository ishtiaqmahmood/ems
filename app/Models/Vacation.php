<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'description',
        'letter_pdf',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Relationship: each vacation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot methods
     */
    public static function boot()
    {
        parent::boot();

        // Auto-calculate total_days
        static::creating(function ($vacation) {
            $vacation->total_days = self::computeDays($vacation->start_date, $vacation->end_date);
        });

        static::updating(function ($vacation) {
            // Recalculate days when date changes
            if ($vacation->isDirty(['start_date', 'end_date'])) {
                $vacation->total_days = self::computeDays($vacation->start_date, $vacation->end_date);
            }

            // Delete old PDF if replaced
            if ($vacation->isDirty('letter_pdf')) {
                $original = $vacation->getOriginal('letter_pdf');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });

        // Delete PDF when vacation record is deleted
        static::deleting(function ($vacation) {
            if ($vacation->letter_pdf && Storage::disk('public')->exists($vacation->letter_pdf)) {
                Storage::disk('public')->delete($vacation->letter_pdf);
            }
        });
    }

    /**
     * Helper to compute days.
     */
    private static function computeDays($start, $end)
    {
        return $start && $end
            ? (new \DateTime($end))->diff(new \DateTime($start))->days + 1
            : 0;
    }

    /**
     * Accessor: Full PDF URL
     */
    public function getLetterPdfUrlAttribute()
    {
        return $this->letter_pdf
            ? asset('storage/' . $this->letter_pdf)
            : null;
    }
}

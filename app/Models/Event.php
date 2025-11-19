<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'location',
        'color',
        'user_id',   // who created the event
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime'   => 'datetime',
    ];

    // -----------------------------
    // Relationships
    // -----------------------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -----------------------------
    // Scopes
    // -----------------------------

    // Get events for a specific date
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('start_datetime', $date);
    }

    // Get events for a date range
    public function scopeBetween($query, $start, $end)
    {
        return $query->whereBetween('start_datetime', [$start, $end]);
    }

    // Monthly events (for calendar)
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month);
    }

    // -----------------------------
    // Helpers
    // -----------------------------

    public function isAllDay()
    {
        return $this->start_datetime->format('H:i') === '00:00'
            && $this->end_datetime->format('H:i') === '23:59';
    }

    public function durationInHours()
    {
        return $this->start_datetime->diffInHours($this->end_datetime);
    }

    public function dateKey()
    {
        return $this->start_datetime->format('Y-m-d');
    }
}

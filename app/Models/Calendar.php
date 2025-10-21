<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /** @use HasFactory<\Database\Factories\CalendarFactory> */
    use HasFactory;

    protected $table = 'calendars';

    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'type',
        'user_id',
        'color',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
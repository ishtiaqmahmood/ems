<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'payment_date',
        'payment_method',
        'status',
        'effective_from',
        'effective_to',
    ];

    /**
     * Relationship: A salary belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

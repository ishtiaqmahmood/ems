<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'employee_id',
        'designation',
        'department',
        'joining_date',
        'date_of_birth',
        'gender',
        'national_id',
        'phone',
        'emergency_contact',
        'address',
        'city',
        'country',
        'profile_pic',
        'status',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'joining_date' => 'date',
        'date_of_birth' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get profile picture or default image
     */
    public function getProfilePicAttribute($value)
    {
        return $value
            ? asset('storage/' . $value)
            : asset('images/default-profile.png');
    }

    /**
     * Get the user's full age from date_of_birth
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth
            ? Carbon::parse($this->date_of_birth)->age
            : null;
    }

    /**
     * Format name when retrieved
     */
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */


    /**
     * Store name in proper format
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isHR()
    {
        return $this->role === 'HR';
    }

    public function isViewer()
    {
        return $this->role === 'Viewer';
    }

    public function isActive()
    {
        return $this->status === 'Active';
    }

    public function isSuspended()
    {
        return $this->status === 'Suspended';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
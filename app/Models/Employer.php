<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'department_id',
        'section_id',
        'uuid',
        'name',
        'slug',
        'email',
        'phone',
        'designation',
        'gender',
        'date_of_birth',
        'blood_group',
        'country',
        'city',
        'state',
        'postal_code',
        'address',
        'profile_image',
        'documents',
        'joining_date',
        'resign_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_relation',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'documents' => 'array',
        'joining_date' => 'date',
        'resign_date' => 'date',
        'date_of_birth' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot Methods - Auto generate UUID, slug & audit logs
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($employer) {
            if (empty($employer->uuid)) {
                $employer->uuid = Str::uuid();
            }

            if (empty($employer->slug)) {
                $employer->slug = Str::slug($employer->name) . '-' . Str::random(5);
            }

            if (Auth::check()) {
                $employer->created_by = Auth::id();
            }
        });

        static::updating(function ($employer) {
            if (Auth::check()) {
                $employer->updated_by = Auth::id();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, $term)
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%$term%")
                ->orWhere('email', 'like', "%$term%")
                ->orWhere('phone', 'like', "%$term%")
                ->orWhere('designation', 'like', "%$term%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
            ? asset('uploads/employers/' . $this->profile_image)
            : asset('images/default-avatar.png');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active'     => '<span class="badge bg-success">Active</span>',
            'inactive'   => '<span class="badge bg-secondary">Inactive</span>',
            'terminated' => '<span class="badge bg-danger">Terminated</span>',
            'resigned'   => '<span class="badge bg-warning">Resigned</span>',
            default      => $this->status,
        };
    }

    public function totalSalary()
    {
        return ($this->salary ?? 0) + ($this->allowances ?? 0) - ($this->deductions ?? 0);
    }

    public function hasDocuments()
    {
        return !empty($this->documents);
    }

    public function getDocumentUrlsAttribute()
    {
        if (!$this->documents) return [];

        return collect($this->documents)
            ->map(fn($file) => asset("uploads/employers/documents/$file"));
    }
}

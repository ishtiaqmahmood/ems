<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'uuid',
        'name',
        'slug',
        'code',
        'description',
        'images',
        'status',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug + uuid
        static::creating(function ($department) {
            if (empty($department->slug)) {
                $department->slug = Str::slug($department->name) . '-' . Str::random(6);
            }
            if (empty($department->uuid)) {
                $department->uuid = Str::uuid();
            }

            if (Auth::check()) {
                $department->created_by = Auth::id();
            }
        });

        static::updating(function ($department) {
            if (Auth::check()) {
                $department->updated_by = Auth::id();
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

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function employees()
    {
        return $this->hasMany(Employer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
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

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeSearch($query, $term)
    {
        if ($term === null) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
                ->orWhere('code', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-secondary">Inactive</span>',
            'archived' => '<span class="badge bg-danger">Archived</span>',
            default => $this->status,
        };
    }

    public function getImageUrlsAttribute()
    {
        if (!$this->images) return [];

        return collect($this->images)->map(function ($img) {
            return asset('uploads/departments/' . $img);
        });
    }

    public function hasImage()
    {
        return !empty($this->images);
    }
}

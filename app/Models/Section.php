<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'department_id',
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

    /*
    |--------------------------------------------------------------------------
    | Boot - Auto Generate Data
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            // Auto slug
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->name) . '-' . Str::random(6);
            }

            // Auto UUID
            if (empty($section->uuid)) {
                $section->uuid = Str::uuid();
            }
            // Audit
            if (Auth::check()) {
                $section->created_by = Auth::id();
            }
        });
        static::updating(function ($section) {
            if (Auth::check()) {
                $section->updated_by = Auth::id();
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
        if (!$term) return $query;

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
            'active'   => '<span class="badge bg-success px-2 py-1">Active</span>',
            'inactive' => '<span class="badge bg-secondary px-2 py-1">Inactive</span>',
            'archived' => '<span class="badge bg-danger px-2 py-1">Archived</span>',
            default    => $this->status
        };
    }

    public function getImageUrlsAttribute()
    {
        if (!$this->images) return [];

        return collect($this->images)->map(fn($img) => asset('uploads/sections/' . $img));
    }

    public function hasImage()
    {
        return !empty($this->images);
    }
}

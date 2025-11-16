<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address',
        'description',
        'logo',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // decode JSON automatically
    ];

    /**
     * Store organization with logo and multiple images.
     */
    public static function storeWithMedia()
    {
        $req = request();
        $data = $req->only(['name', 'email', 'phone', 'website', 'address', 'description']);

        // 🔹 Upload logo
        if ($req->hasFile('logo')) {
            $data['logo'] = $req->file('logo')->store('organization_logos', 'public');
        }

        // 🔹 Upload multiple images
        $paths = [];
        if ($req->hasFile('images')) {
            foreach ($req->file('images') as $image) {
                $paths[] = $image->store('organization_images', 'public');
            }
        }
        $data['images'] = $paths;

        return self::create($data);
    }

    /**
     * Access full URLs for logo and gallery images.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    public function getImageUrlsAttribute()
    {
        return collect($this->images)->map(fn($path) => Storage::url($path))->toArray();
    }
    // Relationships
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function employees()
    {
        return $this->hasMany(Employer::class);
    }
}

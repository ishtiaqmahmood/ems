<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'user_id',
        'category',
        'tags',
        'visibility',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    public function getShortTitleAttribute()
    {
        return strlen($this->title) > 25 ? substr($this->title, 0, 25) . '...' : $this->title;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }

    public function formattedDate()
    {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Helper: check visibility status
     */
    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }

    public function isPrivate(): bool
    {
        return $this->visibility === 'private';
    }
}
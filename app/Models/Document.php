<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'type',
        'description',
        'visibility',
    ];

    protected $appends = ['file_url'];

    // Relationship: Document belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for file URL
    public function getFileUrlAttribute(): string
    {
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }

        return Storage::url($this->file_path);
    }
}

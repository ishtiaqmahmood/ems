<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photos extends Model
{
    /** @use HasFactory<\Database\Factories\PhotosFactory> */
    use HasFactory;
    protected $fillable = [
        'uploaded_by',
        'updated_by',
        'title',
        'file_path',
        'extension',
        'mime_type',
        'description',
    ];

    protected $appends = ['url'];

    // Generate public URL
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }


    // Uploaded by user
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Updated by user
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

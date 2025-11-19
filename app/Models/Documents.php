<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documents extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentsFactory> */
    use HasFactory;

    protected $fillable = [
        'uploaded_by',
        'updated_by',
        'title',
        'file_path',
        'type',
        'extension',
        'mime_type',
        'description',
    ];

    /**
     * Relationship: Uploaded by user (admin)
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relationship: Updated by user (admin)
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Accessor: Full URL for the stored file
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Store file with UUID name
     */
    public static function storeDocument($file)
    {
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('documents', $filename, 'public');
    }
}

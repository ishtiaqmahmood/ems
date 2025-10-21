<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    /**
     * Display a listing of public photos and user’s private photos.
     */
    public function index()
    {
        $photos = Photo::where(function ($query) {
            $query->where('visibility', 'public')
                ->orWhere('user_id', Auth::id());
        })->latest()->paginate(9);

        return view('photos.index', compact('photos'));
    }

    /**
     * Show form to upload a new photo.
     */
    public function create()
    {
        return view('photos.create');
    }

    /**
     * Store a newly uploaded photo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'visibility' => 'required|in:public,private',
        ]);

        $path = $request->file('image')->store('uploads/photos', 'public');
        Photo::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'user_id' => Auth::id(),
            'visibility' => $validated['visibility'],
        ]);

        return redirect()->route('photos.index')->with('success', 'Photo uploaded successfully!');
    }

    /**
     * Show a single photo.
     */
    public function show(Photo $photo)
    {
        // Access control
        if ($photo->visibility === 'private' && $photo->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to view this photo.');
        }

        $photo->incrementViews();

        return view('photos.show', compact('photo'));
    }

    /**
     * Delete a photo.
     */
    public function destroy(Photo $photo)
    {
        if ($photo->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to delete this photo.');
        }

        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Photo deleted successfully!');
    }
}
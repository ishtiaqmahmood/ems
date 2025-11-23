<?php

namespace App\Http\Controllers\admin\Photos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Photos as Photo;

class ImageController extends Controller
{
    /**
     * Display all photos
     */
    public function index(Request $request)
    {
        $query = Photo::query();

        // Search by title
        if ($request->search) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by file type
        if ($request->type) {
            $query->where('extension', $request->type);
        }

        // Sorting
        if ($request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($request->sort == 'type') {
            $query->orderBy('extension', 'asc');
        } else {
            // default newest
            $query->orderBy('created_at', 'desc');
        }

        $photos = $query->paginate(20);

        // get unique file types for filter dropdown
        $types = Photo::select('extension')->distinct()->pluck('extension');

        return view('admin.photos.index', compact('photos', 'types'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * Store multiple photos
     */
    public function store(Request $request)
    {
        $request->validate([
            'photos.*' => 'required|image|max:5120', // max 5MB
            'title' => 'nullable|string|max:255',    // optional title for all photos
            'description' => 'nullable|string|max:1000', // optional description
        ]);

        $title = $request->title;           // single title for all photos
        $description = $request->description; // single description for all photos

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('photos', 'public');

                Photo::create([
                    'uploaded_by' => Auth::id(),
                    'title' => $title,
                    'file_path' => $path,
                    'extension' => $file->getClientOriginalExtension(),
                    'mime_type' => $file->getMimeType(),
                    'description' => $description,
                ]);
            }
        }

        return redirect()->route('admin.photos.index')->with('success', 'Photos uploaded successfully!');
    }

    /**
     * Show single photo
     */
    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * Show edit form
     */
    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Update photo
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($photo->file_path);
            $file = $request->file('file');
            $photo->file_path = $file->store('photos', 'public');
            $photo->extension = $file->getClientOriginalExtension();
            $photo->mime_type = $file->getMimeType();
        }

        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->updated_by = Auth::id();
        $photo->save();

        return redirect()->route('admin.photos.index')->with('success', 'Photo updated successfully!');
    }

    /**
     * Delete photo
     */
    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->file_path);
        $photo->delete();

        return back()->with('success', 'Photo deleted successfully!');
    }
}

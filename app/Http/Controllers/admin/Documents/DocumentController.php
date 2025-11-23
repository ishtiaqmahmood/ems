<?php

namespace App\Http\Controllers\admin\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Documents;

class DocumentController extends Controller
{
    /**
     * List all documents
     */
    public function index(Request $request)
    {
        // Get unique types for filter dropdown
        $documentTypes = Documents::select('type')
            ->whereNotNull('type')
            ->distinct()
            ->pluck('type');

        // Query documents with search, filter, sort
        $documents = Documents::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->sort, function ($query) use ($request) {
                if ($request->sort === 'oldest') {
                    return $query->oldest();
                }
                return $query->latest(); // default newest
            })
            ->latest()
            ->paginate(15)
            ->appends($request->query()); // keep filters on pagination

        return view('admin.documents.index', compact('documents', 'documentTypes'));
    }


    public function show(Documents $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a new document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10 MB
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Documents::create([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'file_path' => $path,
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully!');
    }

    /**
     * Edit form
     */
    public function edit(Documents $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update document
     */
    public function update(Request $request, Documents $document)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($document->file_path);

            $file = $request->file('file');
            $path = $file->store('documents', 'public');

            $document->file_path = $path;
            $document->mime_type = $file->getMimeType();
            $document->extension = $file->getClientOriginalExtension();
        }

        $document->title = $request->title;
        $document->type = $request->type;
        $document->description = $request->description;
        $document->updated_by = Auth::id();
        $document->save();

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully!');
    }

    /**
     * Delete document
     */
    public function destroy(Documents $document)
    {
        // Delete file
        Storage::disk('public')->delete($document->file_path);

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Document deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class DocumentController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $user = Auth::user();

        // If admin => show all, else only own
        $documents = $user->role === 'Admin'
            ? Document::latest()->paginate(10)
            : Document::where('user_id', $user->id)->latest()->paginate(10);

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }
    /**
     * Store a newly created document.
     */
    public function store(DocumentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        Document::create($data);

        return redirect()->route('documents.index')
            ->with('success', '✅ Document uploaded successfully!');
    }

    /**
     * Show the specified document (optional for previewing).
     */
    public function show(Document $document)
    {
        $this->authorizeAccess($document);

        return view('documents.show', compact('document'));
    }

    /**
     * Update the specified document.
     */
    public function update(DocumentRequest $request, Document $document)
    {
        $this->authorizeAccess($document);

        $data = $request->validated();

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')
            ->with('success', '✏️ Document updated successfully!');
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Document $document)
    {
        $this->authorizeAccess($document);

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', '🗑️ Document deleted successfully!');
    }

    /**
     * Secure access control.
     */
    private function authorizeAccess(Document $document)
    {
        $user = Auth::user();
        if ($document->user_id !== $user->id && $user->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
    }
}

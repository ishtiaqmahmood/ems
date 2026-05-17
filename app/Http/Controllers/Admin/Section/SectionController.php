<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Section::with(['organization', 'department']);

        // 🔹 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('organization', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('department', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 🔹 Sorting
        $sortBy = $request->get('sort_by', 'created_at'); // default column
        $sortOrder = $request->get('sort_order', 'desc'); // default order

        // Ensure valid sort column and order
        $allowedSorts = ['name', 'created_at', 'updated_at', 'status'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $sections = $query->orderBy($sortBy, $sortOrder)
            ->paginate(20)
            ->withQueryString(); // keeps search and sort params in pagination links

        return view('admin.sections.index', compact('sections'));
    }
    public function create()
    {
        $organizations = Organization::all();
        return view('admin.sections.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'images.*' => 'image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $images[] = $img->store('sections', 'public');
            }
        }

        Section::create([
            'organization_id' => $request->organization_id,
            'department_id' => $request->department_id,
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => strtoupper(Str::random(6)),
            'images' => $images,
            'description' => $request->description,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully');
    }

    public function show(Section $section)
    {
        return view('admin.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        $organizations = Organization::all();
        $departments = Department::where('organization_id', $section->organization_id)->get();

        return view('admin.sections.edit', compact('section', 'organizations', 'departments'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|max:255',
            'images.*' => 'image|max:2048',
        ]);

        $images = $section->images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $images[] = $img->store('sections', 'public');
            }
        }

        $section->update([
            'organization_id' => $request->organization_id,
            'department_id' => $request->department_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'images' => $images,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted');
    }
}

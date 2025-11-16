<?php

namespace App\Http\Controllers\admin\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function show(Department $department)
    {
        $department->load('organization', 'sections'); // eager load relations
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Display a listing of departments.
     */
    public function index(Request $request)
    {
        $query = Department::with('organization');

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Sort by sort_order
        $departments = $query->orderBy('sort_order', 'asc')->paginate(15);

        return view('admin.departments.index', compact('departments', 'search'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        $organizations = Organization::all();
        return view('admin.departments.create', compact('organizations'));
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,archived',
        ]);

        Department::create([
            'organization_id' => $request->organization_id,
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => strtoupper(Str::random(6)), // auto-generated code
            'description' => $request->description,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        $organizations = Organization::all();
        return view('admin.departments.edit', compact('department', 'organizations'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,archived',
        ]);

        $department->update([
            'organization_id' => $request->organization_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? $department->sort_order,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }

    /**
     * Sort departments
     */
    public function sort(Request $request)
    {
        $order = $request->input('order'); // array of department IDs in new order

        foreach ($order as $index => $id) {
            Department::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}

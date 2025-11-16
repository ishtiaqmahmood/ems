<?php

namespace App\Http\Controllers\admin\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    // List all employers
    public function index(Request $request)
    {
        $query = Employer::with(['organization', 'department', 'section']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                // Search in basic employer fields
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");

                // Search in related department
                $q->orWhereHas('department', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });

                // Search in related section
                $q->orWhereHas('section', function ($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                });

                // Optionally, search in organization
                $q->orWhereHas('organization', function ($q4) use ($search) {
                    $q4->where('name', 'like', "%{$search}%");
                });
            });
        }

        $employers = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.employers.index', compact('employers'));
    }

    // Show form to create
    public function create()
    {
        $organizations = Organization::all();
        $departments = Department::all();
        $sections = Section::all();
        return view('admin.employers.create', compact('organizations', 'departments', 'sections'));
    }

    // Store new employer
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'department_id' => 'nullable|exists:departments,id',
            'section_id' => 'nullable|exists:sections,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'documents.*' => 'nullable|file|max:5120',
            'joining_date' => 'nullable|date',
            'resign_date' => 'nullable|date|after_or_equal:joining_date',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_relation' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,terminated,resigned',
        ]);

        $data = $request->all();

        // UUID
        $data['uuid'] = Str::uuid();

        // Profile Image
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('employers/profile', 'public');
        }

        // Documents
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $doc) {
                $documents[] = $doc->store('employers/docs', 'public');
            }
            $data['documents'] = json_encode($documents);
        }

        $data['created_by'] = Auth::id();

        Employer::create($data);

        return redirect()->route('admin.employers.index')->with('success', 'Employer created successfully.');
    }

    // Show single employer
    public function show(Employer $employer)
    {
        $employer->load(['organization', 'department', 'section']);
        return view('admin.employers.show', compact('employer'));
    }

    // Show edit form
    public function edit(Employer $employer)
    {
        $organizations = Organization::all();
        $departments = Department::all();
        $sections = Section::all();
        return view('admin.employers.edit', compact('employer', 'organizations', 'departments', 'sections'));
    }

    // Update employer
    public function update(Request $request, Employer $employer)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'department_id' => 'nullable|exists:departments,id',
            'section_id' => 'nullable|exists:sections,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email,' . $employer->id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'documents.*' => 'nullable|file|max:5120',
            'joining_date' => 'nullable|date',
            'resign_date' => 'nullable|date|after_or_equal:joining_date',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_relation' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,terminated,resigned',
        ]);

        $data = $request->all();

        // Profile Image
        if ($request->hasFile('profile_image')) {
            if ($employer->profile_image) Storage::disk('public')->delete($employer->profile_image);
            $data['profile_image'] = $request->file('profile_image')->store('employers/profile', 'public');
        }

        // Documents
        if ($request->hasFile('documents')) {
            $documents = json_decode($employer->documents, true) ?? [];
            foreach ($request->file('documents') as $doc) {
                $documents[] = $doc->store('employers/docs', 'public');
            }
            $data['documents'] = json_encode($documents);
        }

        $data['updated_by'] = Auth::id();

        $employer->update($data);

        return redirect()->route('admin.employers.index')->with('success', 'Employer updated successfully.');
    }

    // Delete employer
    public function destroy(Employer $employer)
    {
        if ($employer->profile_image) Storage::disk('public')->delete($employer->profile_image);

        if ($employer->documents) {
            foreach (json_decode($employer->documents) as $doc) {
                Storage::disk('public')->delete($doc);
            }
        }

        $employer->delete();

        return redirect()->route('admin.employers.index')->with('success', 'Employer deleted successfully.');
    }
}

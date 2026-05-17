<?php

namespace App\Http\Controllers\Admin\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreEmployerRequest;
use App\Http\Requests\Admin\UpdateEmployerRequest;

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
    public function store(StoreEmployerRequest $request)
    {
        $data = $request->validated();

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
            $data['documents'] = $documents; // Cast handles JSON
        }

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
    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        $data = $request->validated();

        // Profile Image
        if ($request->hasFile('profile_image')) {
            if ($employer->profile_image) Storage::disk('public')->delete($employer->profile_image);
            $data['profile_image'] = $request->file('profile_image')->store('employers/profile', 'public');
        }

        // Documents
        if ($request->hasFile('documents')) {
            $documents = $employer->documents ?? [];
            foreach ($request->file('documents') as $doc) {
                $documents[] = $doc->store('employers/docs', 'public');
            }
            $data['documents'] = $documents; // Cast handles JSON
        }

        $employer->update($data);

        return redirect()->route('admin.employers.index')->with('success', 'Employer updated successfully.');
    }

    // Delete employer
    public function destroy(Employer $employer)
    {
        if ($employer->profile_image) Storage::disk('public')->delete($employer->profile_image);

        if ($employer->documents) {
            foreach ($employer->documents as $doc) {
                Storage::disk('public')->delete($doc);
            }
        }

        $employer->delete();

        return redirect()->route('admin.employers.index')->with('success', 'Employer deleted successfully.');
    }
}

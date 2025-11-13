<?php

namespace App\Http\Controllers\admin\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email',
            'phone'       => 'nullable|string|max:20',
            'website'     => 'nullable|url',
            'address'     => 'nullable|string',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'website', 'address', 'description']);

        // Upload logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('organization_logos', 'public');
        }

        // Upload multiple images
        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('organization_images', 'public');
            }
        }
        $data['images'] = $paths;

        Organization::create($data);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization created successfully!');
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email',
            'phone'       => 'nullable|string|max:20',
            'website'     => 'nullable|url',
            'address'     => 'nullable|string',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'website', 'address', 'description']);

        // Replace logo if uploaded
        if ($request->hasFile('logo')) {
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            $data['logo'] = $request->file('logo')->store('organization_logos', 'public');
        }

        // Add new images (keep old + new)
        $paths = $organization->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('organization_images', 'public');
            }
        }
        $data['images'] = $paths;

        $organization->update($data);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization updated successfully!');
    }

    public function destroy(Organization $organization)
    {
        // Guard against missing or null organization for safety
        if (!isset($organization)) {
            return redirect()->route('admin.organizations.index')->with('error', 'Organization not found.');
        }

        if (!empty($organization->logo)) {
            Storage::disk('public')->delete($organization->logo);
        }
        if (!empty($organization->images)) {
            foreach ($organization->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $organization->delete();

        return redirect()->route('admin.organizations.index')->with('success', 'Organization deleted successfully!');
    }


    public function removeImage(Organization $organization, $imageIndex)
    {
        $images = $organization->images ?? [];
        $imageIndex = (int) $imageIndex;

        if (isset($images[$imageIndex])) {
            // Delete the image file if it exists
            if (Storage::disk('public')->exists($images[$imageIndex])) {
                Storage::disk('public')->delete($images[$imageIndex]);
            }

            // Remove the image from the array and reindex
            unset($images[$imageIndex]);
            $organization->update(['images' => array_values($images)]);
        }

        return redirect()->back()->with('success', 'Image removed successfully!');
    }
}
<?php

namespace App\Http\Controllers\admin\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::latest()->paginate(10);
        return view('admin.leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('admin.leave-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:leave_types,code',
            'name_bn' => 'required|string',
            'name_en' => 'required|string',
            'max_duration' => 'nullable|integer|min:1',
            'duration_unit' => 'required|in:day,month,year',
            'requires_medical' => 'boolean',
            'paid' => 'boolean',
            'lifetime_limit' => 'boolean',
            'description' => 'nullable|string',
        ]);

        LeaveType::create($data);

        return redirect()
            ->route('admin.leave-types.index')
            ->with('success', 'Leave type created successfully.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('admin.leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:leave_types,code,' . $leaveType->id,
            'name_bn' => 'required|string',
            'name_en' => 'required|string',
            'max_duration' => 'nullable|integer|min:1',
            'duration_unit' => 'required|in:day,month,year',
            'requires_medical' => 'boolean',
            'paid' => 'boolean',
            'lifetime_limit' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $leaveType->update($data);

        return redirect()
            ->route('admin.leave-types.index')
            ->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();

        return redirect()
            ->route('admin.leave-types.index')
            ->with('success', 'Leave type deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\admin\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\LeaveType;

class LeaveController extends Controller
{
    // Show all leave applications
    public function index(Request $request)
    {
        $query = Vacation::with('user')->latest();

        // Search by user name, type, or status
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        }

        // Paginate results
        $leaves = $query->paginate(15);

        // Keep search query in pagination links
        $leaves->appends($request->only('search'));

        $leaveTypes = LeaveType::latest()->paginate(10);

        return view('admin.leaves.index', compact('leaves', 'leaveTypes'));
    }


    // Show single leave application
    public function show($id)
    {
        $leave = Vacation::with('user')->findOrFail($id);
        return view('admin.leaves.show', compact('leave'));
    }

    // Update leave status (approve / reject)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $leave = Vacation::findOrFail($id);
        $leave->status = $request->status;
        $leave->save();

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave status updated successfully');
    }

    // Delete leave application
    public function destroy($id)
    {
        $leave = Vacation::findOrFail($id);
        $leave->delete();

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave application deleted successfully');
    }
}

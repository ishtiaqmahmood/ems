<?php

namespace App\Http\Controllers\Vacation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DisabilityLeaveFormController extends Controller
{
    /**
     * Show create form
     */
    public function create()
    {
        $column = app()->getLocale() === 'bn' ? 'name_bn' : 'name_en';
        $leaveTypes = LeaveType::orderBy($column)->get();

        $employees = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('vacations.disability', compact('leaveTypes', 'employees'));
    }

    /**
     * Store vacation request
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $user = Auth::user();

        if ($this->hasAppliedToday($user->id)) {
            return back()->withErrors([
                'error' => 'You can apply for leave only once per day.'
            ]);
        }

        $letterPath   = $this->uploadFile($request, 'letter_pdf');

        Vacation::create([
            // Relations
            'user_id'       => $user->id,
            'leave_type_id' => $request->leave_type_id,

            // Employee snapshot
            'mobile'        => $request->mobile ?? $user->mobile,
            'address'       => $request->address ?? $user->address,
            'salary'        => $request->salary ?? $user->salary,
            'designation'   => $request->designation ?? $user->designation,

            // Leave balance
            'due_leave'     => $request->due_leave,
            'earned_leaves' => $request->earned_leaves,
            'leaves_taken'  => $request->leaves_taken,


            // Dates
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,

            // Documents
            'letter_pdf'        => $letterPath,

            // Notes
            'reason'        => $request->reason,
            'description'   => $request->description,

            // Status
            'status'        => 'pending',
            'approved_by'   => null,
            'approved_at'   => null,
        ]);

        return redirect()
            ->route('vacations.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',

            'mobile'        => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'salary'        => 'nullable|numeric|min:0',
            'designation'   => 'nullable|string|max:100',

            'due_leave'     => 'nullable|integer|min:0',
            'earned_leaves' => 'nullable|integer|min:0',
            'leaves_taken'  => 'nullable|integer|min:0',

            'reason'        => 'nullable|string|max:1000',
            'description'   => 'nullable|string|max:2000',

            'letter_pdf'    => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);
    }

    private function hasAppliedToday(int $userId): bool
    {
        return Vacation::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->exists();
    }

    private function uploadFile(Request $request, string $field): ?string
    {
        return $request->hasFile($field)
            ? $request->file($field)->store('vacations', 'public')
            : null;
    }
}

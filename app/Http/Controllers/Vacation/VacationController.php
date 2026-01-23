<?php

namespace App\Http\Controllers\Vacation;

use App\Http\Controllers\Controller;
use App\Models\Vacation;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\User;

class VacationController extends Controller
{
    /**
     * List vacations
     */
    public function index()
    {
        $user = Auth::user();

        $vacations = in_array($user->role, ['Admin', 'HR'])
            ? Vacation::with(['user', 'leaveType'])->latest()->paginate(10)
            : Vacation::with('leaveType')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('vacations.index', compact('vacations'));
    }

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

        return view('vacations.create', compact('leaveTypes', 'employees'));
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
        $medicalPath  = $this->uploadFile($request, 'medical_certificate');

        Vacation::create([
            // Relations
            'user_id'       => $user->id,
            'leave_type_id' => $request->leave_type_id,

            // Employee snapshot
            'mobile'        => $request->mobile ?? $user->mobile,
            'address'       => $request->address ?? $user->address,
            'nid_number'    => $request->nid_number ?? $user->nid_number,
            'salary'        => $request->salary ?? $user->salary,
            'designation'   => $request->designation ?? $user->designation,

            // Leave balance
            'due_leave'     => $request->due_leave,
            'earned_leaves' => $request->earned_leaves,
            'leaves_taken'  => $request->leaves_taken,

            // Replacement
            'replacement_user_id' => $request->replacement_user_id,

            // Dates
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,

            // Documents
            'letter_pdf'        => $letterPath,
            'medical_certificate' => $medicalPath,

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

    /**
     * Edit vacation
     */
    public function edit(Vacation $vacation)
    {
        $this->authorizeOwner($vacation);

        if ($vacation->status !== 'pending') {
            abort(403, 'Only pending requests can be edited.');
        }

        $column = app()->getLocale() === 'bn' ? 'name_bn' : 'name_en';
        $leaveTypes = LeaveType::orderBy($column)->get();

        $employees = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('vacations.edit', compact('vacation', 'leaveTypes', 'employees'));
    }

    /**
     * Update vacation
     */
    public function update(Request $request, Vacation $vacation)
    {
        $this->authorizeOwner($vacation);

        if ($vacation->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Approved or rejected leave cannot be modified.'
            ]);
        }

        $this->validateRequest($request);

        if ($request->hasFile('letter_pdf')) {
            $this->deleteFile($vacation->letter_pdf);
            $vacation->letter_pdf = $this->uploadFile($request, 'letter_pdf');
        }

        if ($request->hasFile('medical_certificate')) {
            $this->deleteFile($vacation->medical_certificate);
            $vacation->medical_certificate = $this->uploadFile($request, 'medical_certificate');
        }

        $vacation->update([
            'leave_type_id' => $request->leave_type_id,

            // Employee snapshot
            'mobile'        => $request->mobile,
            'address'       => $request->address,
            'nid_number'    => $request->nid_number,
            'salary'        => $request->salary,
            'designation'   => $request->designation,

            // Leave balance
            'due_leave'     => $request->due_leave,
            'earned_leaves' => $request->earned_leaves,
            'leaves_taken'  => $request->leaves_taken,

            // Replacement
            'replacement_user_id' => $request->replacement_user_id,

            // Dates
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,

            // Notes
            'reason'        => $request->reason,
            'description'   => $request->description,
        ]);

        return redirect()
            ->route('vacations.index')
            ->with('success', 'Leave request updated successfully.');
    }

    /**
     * Delete vacation
     */
    public function destroy(Vacation $vacation)
    {
        $this->authorizeOwner($vacation);

        if ($vacation->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Only pending leave can be deleted.'
            ]);
        }

        $this->deleteFile($vacation->letter_pdf);
        $this->deleteFile($vacation->medical_certificate);

        $vacation->delete();

        return redirect()
            ->route('vacations.index')
            ->with('success', 'Leave request deleted successfully.');
    }

    /* =========================
       Helper Methods
    ========================= */

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',

            'mobile'        => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'nid_number'    => 'nullable|string|max:50',
            'salary'        => 'nullable|numeric|min:0',
            'designation'   => 'nullable|string|max:100',

            'due_leave'     => 'nullable|integer|min:0',
            'earned_leaves' => 'nullable|integer|min:0',
            'leaves_taken'  => 'nullable|integer|min:0',

            'replacement_user_id' => 'nullable|exists:users,id',

            'reason'        => 'nullable|string|max:1000',
            'description'   => 'nullable|string|max:2000',

            'letter_pdf'    => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'medical_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
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

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function authorizeOwner(Vacation $vacation): void
    {
        if ($vacation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}

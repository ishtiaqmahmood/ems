<?php

namespace App\Http\Controllers\Vacation;

use App\Http\Controllers\Controller;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\LeaveType;

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

        return view('vacations.create', compact('leaveTypes'));
    }

    /**
     * Store vacation request
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $userId = Auth::id();

        // Allow only one request per day
        if ($this->hasAppliedToday($userId)) {
            return back()->withErrors([
                'error' => 'You can apply for leave only once per day.'
            ]);
        }

        $filePath = $this->uploadFile($request);

        Vacation::create([
            'user_id'        => $userId,
            'leave_type_id'  => $request->leave_type_id,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'total_days'     => $this->calculateDays($request),
            'reason'         => $request->reason,
            'description'    => $request->description,
            'medical_certificate' => $request->medical_certificate,
            'letter_pdf'     => $filePath,
            'status'         => 'pending',
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

        return view('vacations.edit', compact('vacation', 'leaveTypes'));
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
            $vacation->letter_pdf = $this->uploadFile($request);
        }

        $vacation->update([
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'total_days'    => $this->calculateDays($request),
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
            'reason'        => 'nullable|string|max:1000',
            'description'   => 'nullable|string|max:2000',
            'letter_pdf'    => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);
    }

    private function calculateDays(Request $request): int
    {
        return Carbon::parse($request->start_date)
            ->diffInDays(Carbon::parse($request->end_date)) + 1;
    }

    private function hasAppliedToday(int $userId): bool
    {
        return Vacation::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->exists();
    }

    private function uploadFile(Request $request): ?string
    {
        return $request->hasFile('letter_pdf')
            ? $request->file('letter_pdf')->store('vacations', 'public')
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

<?php

namespace App\Http\Controllers\Vacation;

use App\Http\Controllers\Controller;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VacationController extends Controller
{
    /**
     * Show all vacations
     */
    public function index()
    {
        $user = Auth::user();

        // HR/Admin: show all
        if (in_array($user->role, ['Admin', 'HR'])) {
            $vacations = Vacation::with('user')->latest()->paginate(10);
        }
        // Normal user: show only own
        else {
            $vacations = Vacation::where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('vacations.index', compact('vacations'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('vacations.create');
    }

    /**
     * Store leave request
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date'   => 'required|date|after_or_equal:today',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'type'         => 'required|in:annual,sick,unpaid,other',
            'reason'       => 'nullable|string|max:1000',
            'description'  => 'nullable|string|max:2000',
            'letter_pdf'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $userId = Auth::id();

        // 🚫 Allow one leave request per day
        $alreadyApplied = Vacation::where('user_id', $userId)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($alreadyApplied) {
            return back()->withErrors(['error' => 'You can apply for leave only once per day.']);
        }

        // Upload file
        $filePath = null;
        if ($request->hasFile('letter_pdf')) {
            $filePath = $request->file('letter_pdf')->store('vacations', 'public');
        }

        Vacation::create([
            'user_id'     => $userId,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'type'        => $request->type,
            'reason'      => $request->reason,
            'description' => $request->description,
            'letter_pdf'   => $filePath,
            'status'      => 'pending', // Admin/HR will update
        ]);

        return redirect()->route('vacations.index')
            ->with('success', 'Leave request submitted successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(Vacation $vacation)
    {
        $this->authorizeOwner($vacation);
        return view('vacations.edit', compact('vacation'));
    }

    /**
     * Update leave request
     */
    public function update(Request $request, Vacation $vacation)
    {
        $this->authorizeOwner($vacation);

        // Cannot edit approved or rejected leaves
        if ($vacation->status !== 'pending') {
            return back()->withErrors(['error' => 'You cannot edit an approved or rejected leave request.']);
        }

        $request->validate([
            'start_date'   => 'required|date|after_or_equal:today',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'type'         => 'required|in:annual,sick,unpaid,other',
            'reason'       => 'nullable|string|max:1000',
            'description'  => 'nullable|string|max:2000',
            'letter_pdf'    => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        // File update
        if ($request->hasFile('letter_pdf')) {
            if ($vacation->letter_pdf && Storage::disk('public')->exists($vacation->letter_pdf)) {
                Storage::disk('public')->delete($vacation->letter_pdf);
            }
            $vacation->letter_pdf = $request->file('letter_pdf')->store('vacations', 'public');
        }

        $vacation->update([
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'type'        => $request->type,
            'reason'      => $request->reason,
            'description' => $request->description,
        ]);

        return redirect()->route('vacations.index')
            ->with('success', 'Leave request updated successfully!');
    }

    /**
     * Delete request (user only)
     */
    public function destroy(Vacation $vacation)
    {
        $this->authorizeOwner($vacation);

        if ($vacation->file_path) {
            Storage::disk('public')->delete($vacation->file_path);
        }

        $vacation->delete();

        return redirect()->route('vacations.index')->with('success', 'Leave request deleted successfully.');
    }

    /**
     * Ensure only the owner can edit/delete
     */
    private function authorizeOwner(Vacation $vacation)
    {
        if ($vacation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}

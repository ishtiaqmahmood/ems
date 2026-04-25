<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function exportPdf()
    {
        $user = Auth::user();

        // Get attendance data based on role
        $attendances = in_array($user->role, ['Admin', 'HR'])
            ? Attendance::with('user')->latest()->get()
            : Attendance::with('user')->where('user_id', $user->id)->latest()->get();

        // Load a Blade view for PDF
        $pdf = Pdf::loadView('attendance.export_pdf', compact('attendances', 'user'));

        // Download the PDF
        return $pdf->download('attendance_records.pdf');
    }
    /// Display attendance list
    public function index()
    {
        $user = Auth::user();

        // Base query
        $query = Attendance::query();

        if (!in_array($user->role, ['Admin', 'HR'])) {
            // Normal user → only their own records
            $query->where('user_id', $user->id);
        }

        // Fetch paginated data
        $attendances = $query->with('user')->latest()->paginate(15);

        // Calculate totals
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalAllTime = (clone $query)->where('status', 'Present')->count();
        $totalThisMonth = (clone $query)
            ->whereMonth('date', $currentMonth)
            ->where('status', 'Present')
            ->count();
        $totalThisYear = (clone $query)
            ->whereYear('date', $currentYear)
            ->where('status', 'Present')
            ->count();

        return view('attendance.index', compact(
            'attendances',
            'user',
            'totalAllTime',
            'totalThisMonth',
            'totalThisYear'
        ));
    }

    // Show create form
    public function create()
    {
        $user = Auth::user();

        // Only Admin/HR can select any user
        $users = in_array($user->role, ['Admin', 'HR']) ? User::all() : collect([$user]);

        return view('attendance.create', compact('users', 'user'));
    }

    // Store attendance
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        // If normal user, force user_id to authenticated user
        if (!in_array($user->role, ['Admin', 'HR'])) {
            $validated['user_id'] = $user->id;
        }

        // Check for duplicate attendance for the same user and date
        $exists = Attendance::where('user_id', $validated['user_id'])
            ->where('date', $validated['date'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Attendance already given for this date.');
        }

        // Save attendance with calculations
        $attendance = new Attendance();
        $attendance->saveWithCalculations($validated);

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Attendance $attendance)
    {
        $user = Auth::user();

        // Check authorization: Admin/HR can see all, others only their own
        if (!in_array($user->role, ['Admin', 'HR']) && $attendance->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $attendance->load('user');

        return view('attendance.show', compact('attendance'));
    }

    // Edit form
    public function edit(Attendance $attendance)
    {
        $user = Auth::user();

        // Prevent normal users from editing others’ records
        if (!in_array($user->role, ['Admin', 'HR']) && $attendance->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $users = in_array($user->role, ['Admin', 'HR']) ? User::all() : collect([$user]);

        return view('attendance.edit', compact('attendance', 'users'));
    }

    // update attendance
    public function update(Request $request, Attendance $attendance)
    {
        $user = Auth::user();

        // Only Admin/HR or record owner can update
        if (!in_array($user->role, ['Admin', 'HR']) && $attendance->user_id !== $user->id) {
            abort(403);
        }

        // Validate input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        // Assign validated data
        $attendance->user_id = $validated['user_id'];
        $attendance->date = $validated['date'];
        $attendance->status = $validated['status'];
        $attendance->check_in = $validated['check_in'];
        $attendance->check_out = $validated['check_out'];

        // Calculate total_hours
        if ($attendance->check_in && $attendance->check_out) {
            $checkIn = Carbon::createFromFormat('H:i', $attendance->check_in);
            $checkOut = Carbon::createFromFormat('H:i', $attendance->check_out);

            if ($checkOut < $checkIn) {
                $checkOut->addDay(); // handle overnight shifts
            }

            $attendance->total_hours = round($checkOut->floatDiffInHours($checkIn), 2);
        } else {
            $attendance->total_hours = null;
        }

        // Save changes
        $attendance->save();

        // Update cumulative totals
        $attendance->updateTotals();

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }


    // Delete attendance
    public function destroy(Attendance $attendance)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['Admin', 'HR']) && $attendance->user_id !== $user->id) {
            abort(403);
        }

        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');
    }
}

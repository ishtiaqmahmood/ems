<?php

namespace App\Http\Controllers\Vacation;

use App\Http\Controllers\Controller;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    // List all leaves (HR/Admin only)
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['Admin', 'HR'])) {
            $vacations = Vacation::with('user')->latest()->paginate(10);
        } else {
            $vacations = Vacation::where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('vacations.index', compact('vacations'));
    }

    // Show form to apply for leave (Viewer)
    public function create()
    {
        return view('vacations.create');
    }

    // Store new leave request
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:annual,sick,unpaid,other',
            'reason' => 'nullable|string|max:1000',
        ]);

        Vacation::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('vacations.index')->with('success', 'Leave request submitted successfully!');
    }

    // Approve or reject leave (HR/Admin only)
    public function updateStatus(Request $request, Vacation $vacation)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'HR'])) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:approved,rejected']);

        $vacation->update(['status' => $request->status]);

        return back()->with('success', 'Leave status updated successfully.');
    }

    public function summary(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', now()->year);

        // Monthly data
        $monthlyData = [];
        foreach (range(1, 12) as $m) {
            $monthlyData[] = Vacation::where('user_id', $user->id)
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $m)
                ->where('status', 'approved')
                ->sum('total_days');
        }

        // Monthly, Yearly, All Time totals
        $monthlyTotal = Vacation::where('user_id', $user->id)
            ->whereYear('start_date', now()->year)
            ->whereMonth('start_date', now()->month)
            ->where('status', 'approved')
            ->sum('total_days');

        $yearlyTotal = Vacation::where('user_id', $user->id)
            ->whereYear('start_date', $year)
            ->where('status', 'approved')
            ->sum('total_days');

        $allTimeTotal = Vacation::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('total_days');

        // Yearly data for chart (last 5 years)
        $yearlyData = [];
        foreach (range(now()->year - 5, now()->year) as $y) {
            $yearlyData[$y] = Vacation::where('user_id', $user->id)
                ->whereYear('start_date', $y)
                ->where('status', 'approved')
                ->sum('total_days');
        }

        // All-time data per year
        $alltimeData = $yearlyData; // can use same as yearlyData if needed

        return view('vacations.summary', compact(
            'monthlyTotal',
            'yearlyTotal',
            'allTimeTotal',
            'monthlyData',
            'year',
            'yearlyData',
            'alltimeData'
        ));
    }


    public function adminSummary(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // Employees summary
        $employees = \App\Models\User::whereIn('role', ['Viewer'])
            ->get()
            ->map(function ($user) use ($month, $year) {
                return [
                    'name' => $user->name,
                    'monthly' => $user->vacations()
                        ->whereYear('start_date', $year)
                        ->whereMonth('start_date', $month)
                        ->where('status', 'approved')
                        ->sum('total_days'),
                    'yearly' => $user->vacations()
                        ->whereYear('start_date', $year)
                        ->where('status', 'approved')
                        ->sum('total_days'),
                    'all_time' => $user->vacations()
                        ->where('status', 'approved')
                        ->sum('total_days'),
                ];
            });

        // Overall totals
        $overall = [
            'monthly' => \App\Models\Vacation::whereYear('start_date', $year)
                ->whereMonth('start_date', $month)
                ->where('status', 'approved')
                ->sum('total_days'),
            'yearly' => \App\Models\Vacation::whereYear('start_date', $year)
                ->where('status', 'approved')
                ->sum('total_days'),
            'all_time' => \App\Models\Vacation::where('status', 'approved')->sum('total_days'),
        ];

        // Monthly data for Chart.js
        $monthlyData = [];
        foreach (\App\Models\User::whereIn('role', ['Viewer'])->get() as $user) {
            $monthlyCounts = [];
            foreach (range(1, 12) as $m) {
                $monthlyCounts[] = $user->vacations()
                    ->whereYear('start_date', $year)
                    ->whereMonth('start_date', $m)
                    ->where('status', 'approved')
                    ->sum('total_days');
            }

            $monthlyData[] = [
                'label' => $user->name,
                'data' => $monthlyCounts,
                'backgroundColor' => 'rgba(14, 165, 233, 0.6)',
                'borderColor' => 'rgba(14, 165, 233, 1)',
                'borderWidth' => 1,
            ];
        }

        return view('vacations.admin_summary', compact('employees', 'month', 'year', 'overall', 'monthlyData'));
    }
}

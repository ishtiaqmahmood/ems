<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CalendarController extends Controller
{


    public function index($year = null, $month = null)
    {
        $today = Carbon::now();

        $year = $year ? intval($year) : $today->year;
        $month = $month ? intval($month) : $today->month;

        // normalize
        $current = Carbon::createFromDate($year, $month, 1);

        // calendar start weekday for grid (Carbon::firstOfMonth() helps)
        $startOfMonth = $current->copy()->startOfMonth();
        $endOfMonth = $current->copy()->endOfMonth();

        // fetch events in that month
        $events = Calendar::whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->orderBy('date')
            ->get()
            ->groupBy('date'); // keyed by date string

        // prepare data for view
        return view('calendar.index', [
            'current' => $current,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'events' => $events,
            'prev' => $current->copy()->subMonth(),
            'next' => $current->copy()->addMonth(),
        ]);
    }

    /**
     * Store event (leave/holiday/attendance/event)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'type' => ['required', Rule::in(['attendance', 'leave', 'holiday', 'event'])],
            'color' => 'nullable|string|max:7',
        ]);

        $event = Calendar::create(array_merge($validated, [
            'user_id' => Auth::id(),
        ]));

        return redirect()->back()->with('success', 'ইভেন্ট সফলভাবে সংরক্ষিত হয়েছে।');
    }

    /**
     * Update event
     */
    public function update(Request $request, Calendar $event)
    {
        Gate::authorize('update', $event); // ensure you have policy or rely on check below

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'type' => ['required', Rule::in(['attendance', 'leave', 'holiday', 'event'])],
            'color' => 'nullable|string|max:7',
        ]);

        $event->update($validated);

        return redirect()->back()->with('success', 'ইভেন্ট আপডেট হয়েছে।');
    }

    /**
     * Delete event
     */
    public function destroy(Calendar $event)
    {
        Gate::authorize('delete', $event);

        $event->delete();

        return redirect()->back()->with('success', 'ইভেন্ট মোছা হয়েছে।');
    }
}
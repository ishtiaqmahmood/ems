<?php

namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        // Get requested date or default to today
        $dateParam = $request->query('date');
        $current = $dateParam ? Carbon::parse($dateParam) : Carbon::now();

        // Navigation buttons
        $prevMonth = $current->copy()->subMonth()->format('Y-m-d');
        $nextMonth = $current->copy()->addMonth()->format('Y-m-d');

        // Start & end of month
        $startOfMonth = $current->copy()->startOfMonth();
        $endOfMonth   = $current->copy()->endOfMonth();

        // Calendar grid boundaries (Sunday → Saturday)
        $startCalendar = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endCalendar   = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        // Generate days using CarbonPeriod
        $days = iterator_to_array(CarbonPeriod::create($startCalendar, $endCalendar));

        // Load events within calendar range
        $allEvents = Event::whereBetween('start_datetime', [
            $startCalendar->format('Y-m-d 00:00:00'),
            $endCalendar->format('Y-m-d 23:59:59'),
        ])->orderBy('start_datetime')->get();

        // Group events by date
        $events = [];
        foreach ($allEvents as $ev) {
            $dayKey = Carbon::parse($ev->start_datetime)->format('Y-m-d');
            $events[$dayKey][] = [
                'id'    => $ev->id,
                'title' => $ev->title,
                'time'  => Carbon::parse($ev->start_datetime)->format('h:i A'),
                'color' => $ev->color ?? '#0284c7',
            ];
        }

        return view('admin.calendar.index', [
            'current'   => $current,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'days'      => $days,
            'events'    => $events,
        ]);
    }
}

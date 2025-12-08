<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        // Block Admin & HR from using this controller
        if (in_array($user->role, ['Admin', 'HR'])) {
            abort(403, "This dashboard is only for user accounts.");
        }

        $userId = $user->id;

        // Statistics for normal user
        $totalApplied = Vacation::where('user_id', $userId)->count();
        $approved = Vacation::where('user_id', $userId)->where('status', 'approved')->count();
        $pending = Vacation::where('user_id', $userId)->where('status', 'pending')->count();
        $rejected = Vacation::where('user_id', $userId)->where('status', 'rejected')->count();

        // Monthly graph data
        $months = [];
        $monthlyLeaves = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthName = Carbon::now()->subMonths($i)->format('M');
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = Carbon::now()->subMonths($i)->endOfMonth();

            $count = Vacation::where('user_id', $userId)
                ->whereBetween('start_date', [$start, $end])
                ->count();

            $months[] = $monthName;
            $monthlyLeaves[] = $count;
        }

        return view('index', compact(
            'totalApplied',
            'approved',
            'pending',
            'rejected',
            'months',
            'monthlyLeaves'
        ));
    }
}

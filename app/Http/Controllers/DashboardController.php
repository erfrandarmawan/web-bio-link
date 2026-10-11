<?php

namespace App\Http\Controllers;

use App\Models\Analytic;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $period = $request->query('period', 'today');

        $dateRange = match ($period) {
            'today' => [Carbon::today(), Carbon::today()->endOfDay()],
            '7days' => [Carbon::today()->subDays(7), Carbon::now()],
            '30days' => [Carbon::today()->subDays(30), Carbon::now()],
            'month' => [Carbon::today()->startOfMonth(), Carbon::now()],
            default => [Carbon::today(), Carbon::today()->endOfDay()],
        };

        $linkIds = $user->links()->pluck('id');

        $totalClicks = Analytic::whereIn('link_id', $linkIds)
            ->whereBetween('created_at', $dateRange)
            ->count();

        $totalLinks = $user->links()->count();

        $linksWithClicks = Link::whereIn('id', $linkIds)
            ->withCount(['analytics' => function ($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->get();

        $clicksPerDay = Analytic::whereIn('link_id', $linkIds)
            ->whereBetween('created_at', $dateRange)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard.index', [
            'totalClicks' => $totalClicks,
            'totalLinks' => $totalLinks,
            'linksWithClicks' => $linksWithClicks,
            'clicksPerDay' => $clicksPerDay,
            'period' => $period,
        ]);
    }
}

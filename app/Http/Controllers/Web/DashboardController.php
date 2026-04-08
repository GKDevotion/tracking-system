<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter  = $request->get('filter', 'daily');
        $chartData = $this->getChartData($filter);
        $latest10  = Tracking::with('user')->latest()->take(10)->get();

        $totalTrackings = Tracking::count();
        $todayTrackings = Tracking::whereDate('date', today())->count();
        $totalUsers     = \App\Models\User::count();
        $totalVendors   = Tracking::distinct('vendor')->count('vendor');

        return view('backend.pages.dashboard.index', compact(
            'filter', 'chartData', 'latest10',
            'totalTrackings', 'todayTrackings', 'totalUsers', 'totalVendors'
        ));
    }

    private function getChartData(string $filter): array
    {
        return match ($filter) {
            'weekly'  => $this->weeklyData(),
            'monthly' => $this->monthlyData(),
            'yearly'  => $this->yearlyData(),
            default   => $this->dailyData(),
        };
    }

    private function dailyData(): array
    {
        $data = Tracking::select(DB::raw('HOUR(created_at) as label'), DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', today())
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return [
            'labels' => $data->pluck('label')->map(fn($h) => sprintf('%02d:00', $h))->toArray(),
            'values' => $data->pluck('total')->toArray(),
        ];
    }

    private function weeklyData(): array
    {
        $data = Tracking::select(DB::raw('DAYNAME(date) as label'), DB::raw('COUNT(*) as total'))
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('label', DB::raw('DAYOFWEEK(date)'))
            ->orderBy(DB::raw('DAYOFWEEK(date)'))
            ->get();

        return [
            'labels' => $data->pluck('label')->toArray(),
            'values' => $data->pluck('total')->toArray(),
        ];
    }

    private function monthlyData(): array
    {
        $data = Tracking::select(DB::raw('DAY(date) as label'), DB::raw('COUNT(*) as total'))
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return [
            'labels' => $data->pluck('label')->map(fn($d) => 'Day ' . $d)->toArray(),
            'values' => $data->pluck('total')->toArray(),
        ];
    }

    private function yearlyData(): array
    {
        $data = Tracking::select(DB::raw('MONTHNAME(date) as label'), DB::raw('COUNT(*) as total'))
            ->whereYear('date', now()->year)
            ->groupBy('label', DB::raw('MONTH(date)'))
            ->orderBy(DB::raw('MONTH(date)'))
            ->get();

        return [
            'labels' => $data->pluck('label')->toArray(),
            'values' => $data->pluck('total')->toArray(),
        ];
    }
}

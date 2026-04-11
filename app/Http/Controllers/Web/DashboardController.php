<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BmClient;
use App\Models\BmMailLog;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter  = $request->get('filter', 'daily');
        $chartData = $this->getChartData($filter);
        $latestRecords  = Tracking::with('user')->latest()->take(10)->get();

        $totalTrackings = Tracking::count();
        $todayTrackings = Tracking::whereDate('date', today())->count();
        $totalUsers     = \App\Models\User::count();
        $totalVendors   = Tracking::distinct('vendor')->count('vendor');

        $totalSent   = BmMailLog::where('status', 'sent')->count();
        $totalFailed = BmMailLog::where('status', 'failed')->count();
        $total       = $totalSent + $totalFailed;

        $stats = [
            'total_clients'     => BmClient::count(),
            'clients_this_month'=> BmClient::whereMonth('created_at', now()->month)->count(),
            'total_sent'        => $totalSent,
            'total_failed'      => $totalFailed,
            'failure_rate'      => $total > 0 ? round($totalFailed / $total * 100, 1) : 0,
            'bulk_campaigns'    => BmMailLog::where('is_bulk', true)->distinct('campaign_id')->count('campaign_id'),
            'today_sent'        => BmMailLog::where('status', 'sent')->whereDate('sent_at', today())->count(),
            'unsent_clients'    => BmClient::where('sent', 0)->where('status', 1)->count(),
        ];

        $recentLogs = BmMailLog::with('client:id,name,company_name', 'template:id,name')->latest('sent_at')->limit(8)->get();

        return view('backend.pages.dashboard.index', compact(
            'filter', 'chartData', 'latestRecords', 'stats', 'recentLogs',
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

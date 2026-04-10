<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BmMailLog;
use Illuminate\Http\Request;

class BmMailLogController extends Controller
{
    public function index(Request $request)
    {
        $query = BmMailLog::with([
            'client:id,name,company_name',
            'template:id,name',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('is_bulk')) {
            $query->where('is_bulk', $request->is_bulk);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('sent_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('sent_at', '<=', $request->to_date);
        }

        $logs = $query->latest('sent_at')->paginate(25);

        $totalSent   = BmMailLog::where('status', 'sent')->count();
        $totalFailed = BmMailLog::where('status', 'failed')->count();

        $stats = [
            'total_sent'     => $totalSent,
            'total_failed'   => $totalFailed,
            'bulk_campaigns' => BmMailLog::where('is_bulk', true)->distinct('campaign_id')->count('campaign_id'),
            'today_sent'     => BmMailLog::where('status', 'sent')->whereDate('sent_at', today())->count(),
        ];

        return view('business-mail.logs.index', compact('logs', 'stats'));
    }

    /**
     * GET /admin/business-mail/logs/export
     * Download filtered logs as CSV.
     */
    public function export(Request $request)
    {
        $query = BmMailLog::with('client:id,name,company_name,email', 'template:id,name');

        if ($request->filled('status'))    $query->where('status', $request->status);
        if ($request->filled('is_bulk'))   $query->where('is_bulk', $request->is_bulk);
        if ($request->filled('from_date')) $query->whereDate('sent_at', '>=', $request->from_date);
        if ($request->filled('to_date'))   $query->whereDate('sent_at', '<=', $request->to_date);

        $logs = $query->latest('sent_at')->get();

        $filename = 'mail_logs_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Client', 'Company', 'Email Sent To', 'Template', 'Subject', 'Type', 'Status', 'Response', 'Campaign ID', 'Sent At']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->client->name        ?? '',
                    $log->client->company_name ?? '',
                    $log->email_sent_to,
                    $log->template->name ?? '',
                    $log->subject,
                    $log->is_bulk ? 'Bulk' : 'Single',
                    $log->status,
                    $log->response,
                    $log->campaign_id ?? '',
                    $log->sent_at?->format('Y-m-d H:i:s') ?? '',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}

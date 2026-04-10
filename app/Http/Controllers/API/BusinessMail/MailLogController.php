<?php
namespace App\Http\Controllers\API\BusinessMail;

use App\Http\Controllers\Controller;
use App\Models\BmMailLog;
use Illuminate\Http\Request;

class MailLogController extends Controller
{
    /**
     * GET /api/business-mail/logs
     * All logs with filters: status, is_bulk, campaign_id, date range
     */
    public function index(Request $request)
    {
        $query = BmMailLog::with([
            'client:id,name,company_name,email',
            'template:id,name,subject',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('is_bulk')) {
            $query->where('is_bulk', $request->boolean('is_bulk'));
        }
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('sent_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('sent_at', '<=', $request->to_date);
        }

        $logs = $query->latest('sent_at')->paginate($request->per_page ?? 20);

        return response()->json(['success' => true, 'data' => $logs]);
    }

    /**
     * GET /api/business-mail/logs/stats
     * Summary counts for dashboard
     */
    public function stats()
    {
        $stats = [
            'total_sent'   => BmMailLog::where('status', 'sent')->count(),
            'total_failed' => BmMailLog::where('status', 'failed')->count(),
            'bulk_campaigns' => BmMailLog::where('is_bulk', true)
                                         ->distinct('campaign_id')
                                         ->count('campaign_id'),
            'today_sent'   => BmMailLog::where('status', 'sent')
                                       ->whereDate('sent_at', today())->count(),
        ];

        return response()->json(['success' => true, 'data' => $stats]);
    }
}

<?php
namespace App\Http\Controllers\API\BusinessMail;

use App\Http\Controllers\Controller;
use App\Models\BmClient;
use App\Models\BmMailTemplate;
use App\Services\BusinessMailService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function __construct(private BusinessMailService $mailService) {}

    // ── CRUD ──────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = BmClient::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('sent')) {
            $query->where('sent', $request->sent);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('company_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json(['success' => true, 'data' => $clients]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:120',
            'company_name'  => 'required|string|max:150',
            'email'         => 'required|email|max:180|unique:bm_clients,email',
            'mobile_number' => 'nullable|string|max:20',
            'website'       => 'nullable|url|max:255',
            'address'       => 'nullable|string',
            'status'        => 'nullable|in:0,1',
        ]);

        $validated['status'] = $validated['status'] ?? 1;
        $client = BmClient::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully.',
            'data'    => $client,
        ], 201);
    }

    public function show(BmClient $client)
    {
        return response()->json([
            'success' => true,
            'data'    => $client->load('logs.template'),
        ]);
    }

    public function update(Request $request, BmClient $client)
    {
        $validated = $request->validate([
            'name'          => 'sometimes|required|string|max:120',
            'company_name'  => 'sometimes|required|string|max:150',
            'email'         => ['sometimes', 'required', 'email', 'max:180',
                                Rule::unique('bm_clients', 'email')->ignore($client->id)],
            'mobile_number' => 'nullable|string|max:20',
            'website'       => 'nullable|url|max:255',
            'address'       => 'nullable|string',
            'status'        => 'nullable|in:0,1',
        ]);

        $client->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client updated successfully.',
            'data'    => $client->fresh(),
        ]);
    }

    public function destroy(BmClient $client)
    {
        $client->delete();

        return response()->json(['success' => true, 'message' => 'Client deleted successfully.']);
    }

    // ── Mail Send ─────────────────────────────────────────────────────

    /**
     * POST /api/business-mail/clients/{client}/send-mail
     *
     * Body: { "template_id": 1 }
     *
     * Sends selected mail template to this single client.
     */
    public function sendMail(Request $request, BmClient $client)
    {
        $request->validate([
            'template_id' => 'required|exists:bm_mail_templates,id',
        ]);

        $template = BmMailTemplate::findOrFail($request->template_id);

        if ($template->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Selected template is disabled. Please choose an enabled template.',
            ], 422);
        }

        if ($client->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'This client is disabled. Enable the client before sending mail.',
            ], 422);
        }

        $result = $this->mailService->sendToClient($client, $template);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'data'    => [
                'log'    => $result['log'],
                'client' => $client->fresh(),
            ],
        ], $result['success'] ? 200 : 422);
    }

    /**
     * POST /api/business-mail/clients/bulk-send
     *
     * Body: { "client_ids": [1,2,3], "template_id": 1 }
     *
     * Sends to all selected (enabled) clients in one campaign.
     * Each client's sent/response is updated individually.
     */
    public function bulkSend(Request $request)
    {
        $request->validate([
            'client_ids'   => 'required|array|min:1',
            'client_ids.*' => 'integer|exists:bm_clients,id',
            'template_id'  => 'required|exists:bm_mail_templates,id',
        ]);

        $template = BmMailTemplate::findOrFail($request->template_id);

        if ($template->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Selected template is disabled. Please choose an enabled template.',
            ], 422);
        }

        $results = $this->mailService->sendBulk($request->client_ids, $template);

        $success = $results['failed'] === 0;
        $message = $success
            ? "All {$results['sent']} mails sent successfully."
            : "{$results['sent']} sent, {$results['failed']} failed. Check details for errors.";

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $results,
        ], $success ? 200 : 207); // 207 Multi-Status for partial success
    }

    /**
     * GET /api/business-mail/clients/{client}/mail-logs
     *
     * Full mail history for one client.
     */
    public function mailLogs(Request $request, BmClient $client)
    {
        $logs = $client->logs()
            ->with('template:id,name,subject')
            ->paginate($request->per_page ?? 20);

        return response()->json(['success' => true, 'data' => $logs]);
    }
}

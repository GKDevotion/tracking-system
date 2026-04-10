<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BmClient;
use App\Models\BmMailTemplate;
use App\Services\BusinessMailService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BmClientController extends Controller
{
    public function __construct(private BusinessMailService $mailService) {

    }

    public function index(Request $request)
    {
        $query = BmClient::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('company_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('sent')) {
            $query->where('sent', $request->sent);
        }

        $clients         = $query->latest()->paginate(20);
        $enabledTemplates = BmMailTemplate::where('status', 1)->orderBy('name')->get();
        $activeClients   = BmClient::where('status', 1)->orderBy('company_name')->get();

        return view('business-mail.client.index', compact('clients', 'enabledTemplates', 'activeClients'));
    }

    public function create()
    {
        return view('business-mail.client.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:120',
            'company_name'  => 'required|string|max:150',
            'email'         => 'required|email|max:180|unique:bm_clients,email',
            'mobile_number' => 'nullable|string|max:20',
            'website'       => 'nullable|url|max:255',
            'address'       => 'nullable|string',
            'status'        => 'nullable|in:0,1',
        ]);

        $data['status'] = $data['status'] ?? 1;
        BmClient::create($data);

        return redirect()->route('web.bm-client.index')
                         ->with('success', 'Client created successfully.');
    }

    public function edit($id)
    {
        $client = BmClient::find( $id );
        $client->load('logs.template');
        return view('business-mail.client.form', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:120',
            'company_name'  => 'required|string|max:150',
            'email'         => ['required', 'email', 'max:180', Rule::unique('bm_clients', 'email')->ignore($client->id)],
            'mobile_number' => 'nullable|string|max:20',
            'website'       => 'nullable|url|max:255',
            'address'       => 'nullable|string',
            'status'        => 'nullable|in:0,1',
        ]);

        $client = BmClient::find( $id );
        $client->update($data);

        return redirect()->route('web.bm-client.index')
                         ->with('success', 'Client updated successfully.');
    }

    public function destroy(BmClient $client)
    {
        $client->delete();
        return back()->with('success', 'Client deleted successfully.');
    }

    // ── AJAX: single send ─────────────────────────────────────────────

    /**
     * POST /admin/business-mail/clients/{client}/send-mail
     * Called via fetch() from the blade modal — returns JSON.
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
                'message' => 'This client is disabled. Enable the client before sending.',
            ], 422);
        }

        $result = $this->mailService->sendToClient($client, $template);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'client'  => $client->fresh(['sent', 'response', 'sent_at']),
        ], $result['success'] ? 200 : 422);
    }

    // ── AJAX: bulk send ───────────────────────────────────────────────

    /**
     * POST /admin/business-mail/clients/bulk-send
     * Called via fetch() from the blade modal — returns JSON.
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
                'message' => 'Selected template is disabled.',
            ], 422);
        }

        $results = $this->mailService->sendBulk($request->client_ids, $template);

        $success = $results['failed'] === 0;
        $message = $success
            ? "All {$results['sent']} mails sent successfully."
            : "{$results['sent']} sent, {$results['failed']} failed. Check logs for details.";

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $results,
        ], $success ? 200 : 207);
    }
}

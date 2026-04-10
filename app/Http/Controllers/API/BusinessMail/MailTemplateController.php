<?php
namespace App\Http\Controllers\API\BusinessMail;

use App\Http\Controllers\Controller;
use App\Models\BmMailTemplate;
use App\Models\BmClient;
use App\Services\BusinessMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MailTemplateController extends Controller
{
    public function __construct(private BusinessMailService $mailService) {}

    public function index(Request $request)
    {
        $query = BmMailTemplate::with('category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }

        $templates = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json(['success' => true, 'data' => $templates]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'       => 'nullable|exists:bm_categories,id',
            'name'              => 'required|string|max:150|unique:bm_mail_templates,name',
            'slug'              => 'nullable|string|max:170|unique:bm_mail_templates,slug',
            'subject'           => 'required|string|max:255',
            'short_description' => 'nullable|string|max:350',
            'mail_template'     => 'required|string',    // HTML body
            'status'            => 'nullable|in:0,1',
        ]);

        $validated['slug']   = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['status'] = $validated['status'] ?? 1;

        $template = BmMailTemplate::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Template created successfully.',
            'data'    => $template->load('category'),
        ], 201);
    }

    public function show(BmMailTemplate $mailTemplate)
    {
        return response()->json([
            'success' => true,
            'data'    => $mailTemplate->load('category'),
        ]);
    }

    public function update(Request $request, BmMailTemplate $mailTemplate)
    {
        $validated = $request->validate([
            'category_id'       => 'nullable|exists:bm_categories,id',
            'name'              => ['sometimes', 'required', 'string', 'max:150',
                                    Rule::unique('bm_mail_templates', 'name')->ignore($mailTemplate->id)],
            'slug'              => ['nullable', 'string', 'max:170',
                                    Rule::unique('bm_mail_templates', 'slug')->ignore($mailTemplate->id)],
            'subject'           => 'sometimes|required|string|max:255',
            'short_description' => 'nullable|string|max:350',
            'mail_template'     => 'sometimes|required|string',
            'status'            => 'nullable|in:0,1',
        ]);

        $mailTemplate->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Template updated successfully.',
            'data'    => $mailTemplate->fresh()->load('category'),
        ]);
    }

    public function destroy(BmMailTemplate $mailTemplate)
    {
        $mailTemplate->delete();

        return response()->json(['success' => true, 'message' => 'Template deleted successfully.']);
    }

    /**
     * POST /api/business-mail/templates/{template}/send-to-client
     * Send this template to a specific client.
     */
    public function sendToClient(Request $request, BmMailTemplate $mailTemplate)
    {
        $request->validate([
            'client_id' => 'required|exists:bm_clients,id',
        ]);

        if ($mailTemplate->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'This template is disabled and cannot be sent.',
            ], 422);
        }

        $client = BmClient::findOrFail($request->client_id);
        $result = $this->mailService->sendToClient($client, $mailTemplate);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'log'     => $result['log'],
        ], $result['success'] ? 200 : 422);
    }
}

<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BmCategory;
use App\Models\BmClient;
use App\Models\BmMailTemplate;
use App\Services\BusinessMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BmMailTemplateController extends Controller
{
    public function __construct(private BusinessMailService $mailService) {}

    public function index(Request $request)
    {
        $query = BmMailTemplate::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $templates     = $query->latest()->paginate(15);
        $categories    = BmCategory::where('status', 1)->orderBy('name')->get();
        $activeClients = BmClient::where('status', 1)->orderBy('company_name')->get();

        return view('business-mail.template.index', compact('templates', 'categories', 'activeClients'));
    }

    public function create()
    {
        $categories = BmCategory::where('status', 1)->orderBy('name')->get();
        return view('business-mail.template.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'       => 'nullable|exists:bm_categories,id',
            'name'              => 'required|string|max:150|unique:bm_mail_templates,name',
            'slug'              => 'nullable|string|max:170|unique:bm_mail_templates,slug',
            'subject'           => 'required|string|max:255',
            'short_description' => 'nullable|string|max:350',
            'mail_template'     => 'required|string',
            'status'            => 'nullable|in:0,1',
        ]);

        $data['slug']   = $data['slug'] ?? Str::slug($data['name']);
        $data['status'] = $data['status'] ?? 1;

        BmMailTemplate::create($data);

        return redirect()->route('web.bm-mail-template.index')
                         ->with('success', 'Template created successfully.');
    }

    public function show(BmMailTemplate $mailTemplate)
    {
        return view('business-mail.template.show', ['template' => $mailTemplate->load('category')]);
    }

    public function edit(Request $request, $id=null)
    {
        $mailTemplate = BmMailTemplate::find( $id );

        $categories = BmCategory::where('status', 1)->orderBy('name')->get();
        return view('business-mail.template.form', [
            'template'   => $mailTemplate,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, BmMailTemplate $mailTemplate)
    {
        $data = $request->validate([
            'category_id'       => 'nullable|exists:bm_categories,id',
            'name'              => ['required', 'string', 'max:150', Rule::unique('bm_mail_templates', 'name')->ignore($mailTemplate->id)],
            'slug'              => ['nullable', 'string', 'max:170', Rule::unique('bm_mail_templates', 'slug')->ignore($mailTemplate->id)],
            'subject'           => 'required|string|max:255',
            'short_description' => 'nullable|string|max:350',
            'mail_template'     => 'required|string',
            'status'            => 'nullable|in:0,1',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $mailTemplate->update($data);

        return redirect()->route('web.bm-mail-template.index')
                         ->with('success', 'Template updated successfully.');
    }

    public function destroy(BmMailTemplate $mailTemplate)
    {
        $mailTemplate->delete();
        return back()->with('success', 'Template deleted successfully.');
    }

    /**
     * Send this template to a selected client (from template list → send button).
     * POST /admin/business-mail/templates/{template}/send-to-client
     */
    public function sendToClient(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:bm_mail_templates,id',
            'client_id'   => 'required|exists:bm_clients,id',
        ]);

        $template = BmMailTemplate::findOrFail($request->template_id);
        $client   = BmClient::findOrFail($request->client_id);

        if ($template->status === 0) {
            return back()->with('error', 'Template is disabled — enable it before sending.');
        }

        $result = $this->mailService->sendToClient($client, $template);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}

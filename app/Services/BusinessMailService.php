<?php
namespace App\Services;

use App\Models\BmClient;
use App\Models\BmMailLog;
use App\Models\BmMailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class BusinessMailService
{
    /**
     * Send mail to a single client.
     *
     * Returns ['success' => bool, 'message' => string, 'log' => BmMailLog]
     */
    public function sendToClient(BmClient $client, BmMailTemplate $template): array
    {
        $subject = $template->subject;
        $body    = $this->parsePlaceholders($template->mail_template, $client);

        try {
            Mail::html($body, function ($message) use ($client, $subject) {
                $message->to($client->email, $client->name)
                        ->subject($subject);
            });

            $log = $this->log($client, $template, 'sent', 'Mail delivered successfully.');
            $this->markClientSent($client, 'Mail delivered successfully.');

            return ['success' => true, 'message' => 'Mail sent successfully.', 'log' => $log];

        } catch (Throwable $e) {
            $error = 'Mail failed: ' . $e->getMessage();
            $log   = $this->log($client, $template, 'failed', $error);
            $this->markClientFailed($client, $error);

            return ['success' => false, 'message' => $error, 'log' => $log];
        }
    }

    /**
     * Send mail to multiple clients (bulk campaign).
     *
     * Returns summary array with per-client results.
     */
    public function sendBulk(array $clientIds, BmMailTemplate $template): array
    {
        $campaignId = (string) Str::uuid();
        $clients    = BmClient::whereIn('id', $clientIds)->where('status', 1)->get();

        $results = ['campaign_id' => $campaignId, 'total' => $clients->count(),
                    'sent' => 0, 'failed' => 0, 'details' => []];

        foreach ($clients as $client) {
            $subject = $template->subject;
            $body    = $this->parsePlaceholders($template->mail_template, $client);

            try {
                Mail::html($body, function ($message) use ($client, $subject) {
                    $message->to($client->email, $client->name)->subject($subject);
                });

                $log = $this->log($client, $template, 'sent', 'Bulk: delivered.', true, $campaignId);
                $this->markClientSent($client, 'Bulk campaign delivered.');
                $results['sent']++;
                $results['details'][] = ['client_id' => $client->id, 'email' => $client->email,
                                          'status' => 'sent', 'log_id' => $log->id];

            } catch (Throwable $e) {
                $error = 'Bulk failed: ' . $e->getMessage();
                $log   = $this->log($client, $template, 'failed', $error, true, $campaignId);
                $this->markClientFailed($client, $error);
                $results['failed']++;
                $results['details'][] = ['client_id' => $client->id, 'email' => $client->email,
                                          'status' => 'failed', 'error' => $e->getMessage(),
                                          'log_id' => $log->id];
            }
        }

        return $results;
    }

    // ── Private helpers ────────────────────────────────────────────────

    private function parsePlaceholders(string $template, BmClient $client): string
    {
        return str_replace(
            ['{{name}}', '{{company}}', '{{email}}', '{{mobile}}', '{{website}}'],
            [$client->name, $client->company_name, $client->email,
             $client->mobile_number ?? '', $client->website ?? ''],
            $template
        );
    }

    private function log(
        BmClient $client,
        BmMailTemplate $template,
        string $status,
        string $response,
        bool $isBulk = false,
        ?string $campaignId = null
    ): BmMailLog {
        return BmMailLog::create([
            'client_id'    => $client->id,
            'template_id'  => $template->id,
            'email_sent_to'=> $client->email,
            'subject'      => $template->subject,
            'status'       => $status,
            'response'     => $response,
            'is_bulk'      => $isBulk,
            'campaign_id'  => $campaignId,
            'sent_at'      => now(),
        ]);
    }

    private function markClientSent(BmClient $client, string $msg): void
    {
        $client->update(['sent' => 1, 'sent_at' => now(), 'response' => $msg]);
    }

    private function markClientFailed(BmClient $client, string $msg): void
    {
        $client->update(['sent' => 0, 'response' => $msg]);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmMailLog extends Model
{
    use HasFactory;

    protected $table = 'bm_mail_logs';

    protected $fillable = [
        'client_id', 'template_id', 'email_sent_to', 'subject',
        'status', 'response', 'is_bulk', 'campaign_id', 'sent_at',
    ];

    protected $casts = [
        'is_bulk' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(BmClient::class, 'client_id');
    }

    public function template()
    {
        return $this->belongsTo(BmMailTemplate::class, 'template_id');
    }
}

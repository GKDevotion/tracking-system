<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmClient extends Model
{
    use HasFactory;

    protected $table = 'bm_clients';

    protected $fillable = [
        'name', 'company_name', 'email', 'mobile_number',
        'website', 'address', 'response', 'status', 'sent', 'sent_at',
    ];

    protected $casts = [
        'status'  => 'integer',
        'sent'    => 'integer',
        'sent_at' => 'datetime',
    ];

    public function logs()
    {
        return $this->hasMany(BmMailLog::class, 'client_id')->latest();
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $fillable = [
        'entity_type',
        'entity_id',
        'chat_id',
        'message_id',
        'type',
    ];
}

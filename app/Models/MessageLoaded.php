<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageLoaded extends Model
{
    protected $fillable = [
        'user_agent',
        'message_id',
        'message_token',
        'message_direction',
        'message_direction',
        'message_message_id',
        'message_to',
        'message_from',
        'message_subject',
        'message_timestamp',
        'message_spam_status',
        'message_tag',
        'org_system',
        'date_linux',
        'event',
        'timestamp',
        'uuid'
    ];
}
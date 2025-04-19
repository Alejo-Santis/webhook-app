<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageLinkClicked extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'url',
        'token',
        'ip_address',
        'user_agent',
        'message_id',
        'message_token',
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

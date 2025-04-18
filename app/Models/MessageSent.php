<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageSent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'details',
        'output',
        'time',
        'sent_with_ssl',
        'timestamp',
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
        'uuid'
    ];
}

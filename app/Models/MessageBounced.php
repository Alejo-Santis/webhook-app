<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageBounced extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'original_message_id',
        'original_message_token',
        'original_message_direction',
        'original_message_message_id',
        'original_message_to',
        'original_message_from',
        'original_message_subject',
        'original_message_timestamp',
        'original_message_spam_status',
        'original_message_tag',

        'bounce_id',
        'bounce_token',
        'bounce_direction',
        'bounce_message_id',
        'bounce_to',
        'bounce_from',
        'bounce_subject',
        'bounce_timestamp',
        'bounce_spam_status',
        'bounce_tag',

        'org_system',
        'date_linux',
        'event',
        'timestamp',
        'uuid'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomainDnsError extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'domain',
        'uuid',
        'dns_checked_at',
        'spf_status',
        'spf_error',
        'dkim_status',
        'dkim_error',
        'mx_status',
        'mx_error',
        'return_path_status',
        'return_path_error',
        'event',
        'timestamp'
    ];
}

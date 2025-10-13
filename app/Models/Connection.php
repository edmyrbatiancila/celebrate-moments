<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    /** @use HasFactory<\Database\Factories\ConnectionFactory> */
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'receiver_id',
        'status', // pending, accepted, rejected, blocked
        'connected_at'
    ];
}

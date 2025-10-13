<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreetingRecipient extends Model
{
    /** @use HasFactory<\Database\Factories\GreetingRecipientFactory> */
    use HasFactory;

    protected $fillable = [
        'greeting_id', 
        'recipient_id', 
        'sent_at', 
        'delivered_at', 
        'viewed_at',
        'is_thanked', 
        'thank_you_message'
    ];
}

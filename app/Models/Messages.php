<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Messages extends Model
{
    use HasFactory, Notifiable;
 protected $fillable = [
        'sender_id',
        'receiver_id',
        'offer_id',
        'message',
        'date_sent',
        'created_at',
        'updated_at',


    ];
}

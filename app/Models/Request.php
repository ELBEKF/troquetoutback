<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Request extends Model
{
use HasFactory, Notifiable;
 protected $fillable = [
        'id',
        'user_id',
        'titre',
        'description',
        'type_demande',

        'date_besoin',

        'created_at',
		'updated_at',

    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reponses_Demande extends Model
{
    use HasFactory, Notifiable;
 protected $fillable = [
        'user_id',
        'titre',
        'description',
        'type_demande',

        'date_besoin',

        'created_at',

    ];
}

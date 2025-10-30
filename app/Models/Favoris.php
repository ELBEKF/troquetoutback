<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favoris extends Model
{
     use HasFactory, Notifiable;
 protected $fillable = [
        'user_id',
        'offer_id',
        'date_ajout',
        'updated_at',


    ];
}

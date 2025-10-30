<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class offers extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'offers';
    public $timestamps = true;

    protected $fillable = [
        'titre',
        'description',
        'sens',
        'type',
        'categorie',
        'etat',
        'prix',
        'caution',
        'localisation',
        'photo',
        'disponibilite',
        'statut',
        'user_id',
    ];
}

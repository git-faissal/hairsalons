<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservations';

    protected $fillable = [
        'prix',
        'categorie',
        'specialiste',
        'type',
        'date',
        'heure',
        'user_id',
       
    ];

        //Un evenement concerne un et unn seule utilisateur
        public function user()
        {
            return $this->belongsTo('App\Models\User');
        }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localite extends Model
{
    use HasFactory;
     protected $fillable = [
        'localite','nature','cause','mesure','attention','solution','besoin','commentaire','commune_id','mesureen'
    ];
}

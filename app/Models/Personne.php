<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    use HasFactory;
     protected $fillable = [
        'localite','nature','cause','prenom','nom','tel','cni','besoin','commentaire','commune_id'
    ];
}

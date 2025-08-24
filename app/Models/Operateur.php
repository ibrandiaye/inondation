<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operateur extends Model
{
    use HasFactory;
     protected $fillable = [
        'nature','cause','prenom','nom','tel','superficie','financement','op','cout','commentaire','commune_id',
        'localite_id','doc'
    ];
}

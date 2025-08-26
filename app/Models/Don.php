<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    use HasFactory;
    protected $fillable = [
        'receptionniste','nature','valeur','donneur','date','cause','region_id',
        'departement_id','arrondissement_id'

    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class);
    }
}

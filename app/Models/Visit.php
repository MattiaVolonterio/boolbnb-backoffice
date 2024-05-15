<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    // relazione 1 a n
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    // Riga da decommentare per fare il seeder, poi ricommentare
    // public $timestamps = false;
}

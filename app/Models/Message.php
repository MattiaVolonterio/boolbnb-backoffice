<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    // relazione 1 a n
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    // Riga da decommentare per fare il seeder, poi ricommentare
    // public $timestamps = false;
}

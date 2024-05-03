<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    // relazione n a n
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}

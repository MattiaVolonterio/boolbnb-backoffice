<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // relazione 1 a n
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    // public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    // relazione 1 a n
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}

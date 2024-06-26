<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $distance;

    protected $fillable = [
        'name', 'slug', 'n_room', 'n_bathroom', 'n_bed', 'user_id', 'square_meters', 'floor', 'address', 'lat', 'lon', 'visible',
    ];


    // relazione 1 a n
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // relazione 1 a n
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // relazione 1 a n
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relazione n a n
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    // relazione n a n
    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class)->withPivot('start_date', 'end_date');
    }

    // relazione 1 a n
    public function apartmentImages()
    {
        return $this->hasMany(ApartmentImage::class);
    }
}

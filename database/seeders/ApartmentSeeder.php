<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

// faker
use Faker\Generator as Faker;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // recupero gli ID degli utenti
        $users = User::all()->pluck('id');

        // apre il file csv
        $file = fopen(__DIR__ . '/../csv/apartments.csv', 'r');

        // variabile di controllo della prima riga del csv
        $is_first_line = true;

        // ciclo che itera ogni riga del csv e per ognuna di queste salva un apartment sul database
        while ($apartment_data = fgetcsv($file)) {
            if (!$is_first_line) {
                // nuovo apartment
                $apartment = new Apartment;
                $apartment->user_id = $faker->randomElement($users);
                $apartment->name = $apartment_data[0];
                $apartment->slug = Str::slug($apartment->name);
                $apartment->n_room = $apartment_data[1];
                $apartment->n_bathroom = $apartment_data[2];
                $apartment->n_bed = $apartment_data[3];
                $apartment->square_meters = $apartment_data[4];
                $apartment->floor = $apartment_data[5];
                $apartment->address = $apartment_data[6];
                $apartment->lat = $apartment_data[7];
                $apartment->lon = $apartment_data[8];
                // salvataggio nel db
                $apartment->save();
            }

            // set variabile di controllo su false dopo prima iterazione
            $is_first_line = false;
        }
    }
}

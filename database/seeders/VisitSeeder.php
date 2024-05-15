<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// faker
use Faker\Generator as Faker;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // creazione Visit
    public function run(Faker $faker)
    {

        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            for ($i = 0; $i < rand(1, 100); $i++) {
                $visit = new Visit;
                $visit->apartment_id = $apartment->id;
                $visit->ip_address = $faker->ipv4();
                $creationDate = $faker->dateTimeBetween('-1 year', now(), 'Europe/Rome');
                $visit->created_at = $creationDate;
                $visit->updated_at = $creationDate;
                $visit->save();
            }
        }
    }
}

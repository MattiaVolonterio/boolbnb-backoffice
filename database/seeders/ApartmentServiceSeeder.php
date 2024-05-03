<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// faker
use Faker\Generator as Faker;

class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // recupero tutti gli elementi di apartments e services
        $apartments = Apartment::all();
        $services = Service::all()->pluck('id');

        // per ogni appartamento assegno dei servizi
        foreach($apartments as $apartment){
            $apartment->services()->attach($faker->randomElements($services, rand(1, 5)));
        }

    }
}

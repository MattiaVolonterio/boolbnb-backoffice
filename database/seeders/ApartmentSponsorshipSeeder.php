<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();

        $apartments_sponsored = $faker->unique()->randomElements($apartments, 7);

        foreach($apartments_sponsored as $apartment){

            date_default_timezone_set('Europe/Rome');

            $end_date = strtotime("+240 Hours");
            $end_date = date("Y:m:d H:i:s", $end_date);
            $apartment->sponsorships()->attach(1, ['start_date' => now(), 'end_date' => $end_date]);
            
        }

    }
}

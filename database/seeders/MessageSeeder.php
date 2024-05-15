<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// faker
use Faker\Generator as Faker;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            for ($i = 0; $i < rand(1, 100); $i++) {
                // nuovi messaggi
                $message = new Message;
                $message->apartment_id = $apartment->id;
                $message->customer_email = $faker->email();
                $message->content = 'Buongiorno, avrei bisogno di avere più informazioni su questo appartamento';
                $message->name = $faker->firstName();
                $creationDate = $faker->dateTimeBetween('-1 year', now(), 'Europe/Rome');
                $message->created_at = $creationDate;
                $message->updated_at = $creationDate;
                $message->save();
            }
        }
    }
}

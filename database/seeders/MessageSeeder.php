<?php

namespace Database\Seeders;

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
        // nuovi messaggi
        $message = new Message;

        $message->apartment_id= 3;
        $message->customer_email = 'adriatik.trinita@gmail.com';
        $message->content = $faker->text();
        $message->name = 'Adriatik';
        $message->save();

        $message = new Message;
        $message->apartment_id = 7;
        $message->customer_email = 'andrea.bonvi@gmail.com';
        $message->content = $faker->text();
        $message->name = 'Andrea';
        $message->save();
            
    }
}

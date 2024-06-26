<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        UserSeeder::class, 
        ApartmentSeeder::class,
        SponsorshipSeeder::class,
        MessageSeeder::class,
        VisitSeeder::class,
        ServiceSeeder::class,
        ApartmentServiceSeeder::class,
        ApartmentImageSeeder::class,
        ApartmentSponsorshipSeeder::class
    ]);
    }
}

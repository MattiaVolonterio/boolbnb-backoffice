<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create Basic Sponsorship
        $sponsorship = new Sponsorship;
        $sponsorship->tier = 'Basic';
        $sponsorship->price = 2.99;
        $sponsorship->duration = 24;
        $sponsorship->save();            
        
        //create Premium Sponsorship
        $sponsorship = new Sponsorship;
        $sponsorship->tier = 'Premium';
        $sponsorship->price = 5.99;
        $sponsorship->duration = 72;
        $sponsorship->save();            
        
        //create Super Sponsorship
        $sponsorship = new Sponsorship;
        $sponsorship->tier = 'Super';
        $sponsorship->price = 9.99;
        $sponsorship->duration = 144;
        $sponsorship->save();            
    }
}

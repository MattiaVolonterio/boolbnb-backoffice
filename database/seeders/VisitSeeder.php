<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // creazione Visit
    public function run()
    {
        $visit = new Visit;
        $visit->appartment_id = 3;
        $visit->ip_address='122.122.122.122';
        $visit->save();
    }
}

<?php

namespace Database\Seeders;
use App\Models\Service;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        // apre il file csv
        $file = fopen(__DIR__ . '/../csv/services.csv', 'r');
        
        // variabile di controllo della prima riga del csv
        $is_first_line = true;

        // ciclo che itera ogni riga del csv e per ognuna di queste salva un sevizzio sul database
        while($service_data = fgetcsv($file)){
            if(!$is_first_line){
                // nuovo servizio
                $service = new Service;
                $service->name = $service_data[0]; 
                $service->icon = $service_data[1]; 
                // salvataggio nel db
                $service->save();
            }

            // set variabile di controllo su false dopo prima iterazione
            $is_first_line = false;
        }
    }
}
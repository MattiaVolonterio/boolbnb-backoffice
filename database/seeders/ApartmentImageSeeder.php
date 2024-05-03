<?php

namespace Database\Seeders;

use App\Models\ApartmentImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apre il file csv
        $file = fopen(__DIR__ . "/../csv/apartment_images.csv", "r");

        // variabile di controllo della prima riga del csv
        $is_first_line = true;

        while (!feof($file)) {
            $apartment_image_data = fgetcsv($file);
            if (!$is_first_line) {
                // nuovo ApartmentImage
                $apartment_image = new ApartmentImage;
                $apartment_image->url = $apartment_image_data[1];
                // salvataggio nel db
                $apartment_image->save();
            }

            // set variabile di controllo su false dopo prima iterazione
            $is_first_line = false;
        }




    }
}

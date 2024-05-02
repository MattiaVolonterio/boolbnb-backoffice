<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Legge il file csv
        $data = fopen(__DIR__ . '/../csv/users.csv', 'r');
        // variabile di controllo per la prima linea del file
        $is_first_line = true;

        // ciclo while che per ogni linea del file genera un nuovo utente
        while ($users_data = fgetcsv($data)) {
            if (!$is_first_line) {
                $user = new User;
                $user->email = $users_data[0];
                $user->password = Hash::make($users_data[1]);
                $user->name = $users_data[2];
                $user->surname = $users_data[3];
                $user->birthday = $users_data[4];
                $user->save();
            }
            // setta la variabile a false dopo la prima iterazione
            $is_first_line = false;
        }
    }
}

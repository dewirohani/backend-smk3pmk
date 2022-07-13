<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('11223344'),
                'photo' => 'storage/img/logo.png',
                'level_id' => '1',
            ],
            [
                'username' => 'dedy',
                'email' => 'dedyirawan@gmail.com',
                'password' => bcrypt('11223344'),
                'photo' => 'storage/img/logo.png',
                'level_id' => '2',
            ],
            [
                'username' => 'dewi',
                'email' => 'dewi@gmail.com',
                'password' => bcrypt('11223344'),
                'photo' => 'storage/img/logo.png',
                'level_id' => '3',
            ],
         

           
        ];

        foreach ($users as $user) {
            User::create($user);  
        }
    }
}

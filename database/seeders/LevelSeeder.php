<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level = [
            [
                'name' => 'Admin',
                'description' => '-',
               
            ],
            [
                'name' => 'Guru',
                'description' => '-',
               
            ],
            [
                'name' => 'Siswa',
                'description' => '-',
               
            ],
        ];
        foreach ($level as $row){
            Level::create($row);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $major = [
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => '-',
            ],
            [
                'code' => 'MM',
                'name' => 'Multimedia',
                'description' => '-',
            ],
            [
                'code' => 'TBS',
                'name' => 'Tata Busana',
                'description' => '-',
            ],
            [
                'code' => 'TBG',
                'name' => 'Tata Boga',
                'description' => '-',
            ],
            [
                'code' => 'TKK',
                'name' => 'Tata Kecantikan Kulit & Rambut',
                'description' => '-',
            ],
            [
                'code' => 'AP',
                'name' => 'Akomodasi Perhotelan',
                'description' => '-',
            ],
            [
                'code' => 'DF',
                'name' => 'Desain Fashion',
                'description' => '-',
            ],

        ];
        foreach ($major as $row){
            Major::create($row);
        }
    }
}

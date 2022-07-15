<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodStatus;

class PeriodStatusSeeder extends Seeder
{
   
    public function run()
    {
        $periodStatus = [
            [
                'name' => 'Aktif',
            ],
            [
                'name' => 'Tidak Aktif',
            ],
        ];
        foreach ($periodStatus as $row){
            PeriodStatus::create($row);
        }
    }
}

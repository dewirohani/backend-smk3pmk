<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodStatus;

class PeriodStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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

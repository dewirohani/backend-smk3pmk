<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = [
            [               
                'nama_periode' => ' 1 Tahun',
                'start_date' => '2022-06-01',
                'end_date' => '2022-07-01',
                'status_id' => '1',
            ],
            [               
                'nama_periode' => ' 2 Tahun',
                'start_date' => '2022-08-01',
                'end_date' => '2022-09-01',
                'status_id' => '2',
            ],
          
        ];
        foreach ($period as $row){
            Period::create($row);
        }
    }
}

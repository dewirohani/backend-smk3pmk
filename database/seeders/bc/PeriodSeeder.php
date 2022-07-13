<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;
use Carbon\Carbon;

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
                'nama_periode' => 'Periode 1 Tahun 2022',            
                'start_date' => Carbon::createFromDate(2022, 6, 1, 0),
                'end_date' => Carbon::createFromDate(2022, 9, 1, 0),
                'status' => 'Aktif',
            ],
        ];
        foreach ($period as $row){
            Period::create($row);
        }
    }
}

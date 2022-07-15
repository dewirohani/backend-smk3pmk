<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipReportStatus;

class InternshipReportStatusSeeder extends Seeder
{
  
    public function run()
    {
        $reportStatus = [
            [
                'name' => 'Menunggu',
            ],
            [
                'name' => 'Diterima',
            ],
            [
                'name' => 'Ditolak',
            ],
        ];
        foreach ($reportStatus as $row){
            InternshipReportStatus::create($row);
        }
    }
}

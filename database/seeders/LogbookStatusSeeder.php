<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogbookStatus;

class LogbookStatusSeeder extends Seeder
{
    
    public function run()
    {
        $logbookStatus = [
            [
                'name' => 'Menunggu',
            ],
            [
                'name' => 'Diterima',
            ],
        ];
        foreach ($logbookStatus as $row){
            LogbookStatus::create($row);
        }
    }
}

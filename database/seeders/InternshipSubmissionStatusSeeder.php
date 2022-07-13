<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipSubmissionStatus;

class InternshipSubmissionStatusSeeder extends Seeder
{
  
    public function run()
    {
        $submissionStatus = [
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
        foreach ($submissionStatus as $row){
            InternshipSubmissionStatus::create($row);
        }
    }
}

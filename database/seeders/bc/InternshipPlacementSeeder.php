<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipPlacement;

class InternshipPlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internship_placement = [
            [
                'internship_submission_id' => '1',
                'teacher_id' => '1',    
            ],
        ];
        foreach ($internship_placement as $row){
            InternshipPlacement::create($row);
        }
    }
}

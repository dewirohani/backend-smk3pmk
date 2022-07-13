<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipSubmission;

class InternshipSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internship_submission = [
            [
                'student_id' => '1',
                'grade_id' => '1',
                'major_id' => '1',
                'period_id' => '1',
                'internship_place_id' => '1',
                'status_id' => '1',
                'file' => '-'
            ],
        ];
        foreach ($internship_submission as $row){
            InternshipSubmission::create($row);
        }
    }
}

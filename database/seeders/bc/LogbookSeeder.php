<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logbook;
use Carbon\Carbon;

class LogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logbook = [
            [
                'student_id' => '1',
                'teacher_id' => '1',
                'date_of_logbook' => Carbon::createFromDate(2000, 6, 11, 0),
                'start_time' => Carbon::createFromTime(7, 0, 0, 0),
                'end_time' => Carbon::createFromTime(15, 0, 0, 0),
                'activity' => 'entry data',
            ],
        ];
        foreach ($logbook as $row){
            Logbook::create($row);
        }
    }
}

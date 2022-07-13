<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendance = [
            [
                'student_id' => '1',                        
                'time_of_absent' => Carbon::createFromTime(7, 0, 0, 0),               
            ],
        ];
        foreach ($attendance as $row){
            Attendance::create($row);
        }
    }
}

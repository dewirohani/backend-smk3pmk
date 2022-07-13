<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Student;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = [
            [
                'nis' => '001',
                'name' => 'Dewi Rohani',
                'grade_id' => '1',
                'major_id' => '1',
                'address' => 'Jl. Pintu Gerbang',
                'place_of_birth' => 'Sumenep',
                'date_of_birth' => Carbon::createFromDate(2000, 6, 11, 0),
                'gender' => 'Perempuan',
                'religion' => 'Islam',
                'phone' => '087743331758',
                'year_of_entry' => '2020',
                'user_id' => '2'
            ],
          
        ];
        foreach ($student as $row){
            Student::create($row);
        }
    }
}

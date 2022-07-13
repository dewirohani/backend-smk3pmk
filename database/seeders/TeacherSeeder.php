<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = [
            // [
            //     'nip' => '-',
            //     'name' => '-',
            //     'address' => '-',
            //     'place_of_birth' => '-',
            //     'date_of_birth' => Carbon::createFromDate(8, 8, 8),
            //     'gender' => '-',
            //     'religion' => '-',
            //     'phone' => '-',
            //     'user_id' => '1'
            // ],
            [
                'nip' => '12345678',
                'name' => 'Dedy Irawan',
                'address' => 'Betet',
                'place_of_birth' => 'Pamekasan',
                'date_of_birth' => Carbon::createFromDate(1978, 6, 11),
                'gender' => 'Laki-Laki',
                'religion' => 'Islam',
                'phone' => '087121567089',
                'user_id' => '1'
            ]
            
        ];
        foreach ($teacher as $row){
            Teacher::create($row);
        }
    }
}

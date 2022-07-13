<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\InternshipPlace;

class InternshipPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
 
        $internship_place = [
            [
                'name' => 'ADM Pembangunan',
                'address' => 'Jl Kabupaten',
                'districts' => 'Pamekasan',
                'city' => 'Pamekasan',
                'mentor' => 'Zainal Amir',
                'teacher_id' => '1',
                'phone' => '089734126789',
                'quota' => '4',
                'time_in' => '08:00:00',
                'time_out' => '15:00:00',

            ],
        ];
        foreach ($internship_place as $row){
            InternshipPlace::create($row);
        }
    }
}

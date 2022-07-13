<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = [
            [
                'name' => 'XI RPL 1',
                'major_id' => '1',
                'description' => '-',
            ],
            [
                'name' => 'XI RPL 2',
                'major_id' => '1',
                'description' => '-',
            ],
            [
                'name' => 'XI RPL 3',
                'major_id' => '1',
                'description' => '-',
            ],
            [
                'name' => 'XI Multimedia 1',
                'major_id' => '2',
                'description' => '-',
            ],
            [
                'name' => 'XI Multimedia 2',
                'major_id' => '2',
                'description' => '-',
            ],
        ];
        foreach ($grade as $row){
            Grade::create($row);
        }
    }

}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipCertificate;

class InternshipCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internship_certificate = [
            [
                'student_id' => '1',            
                'teacher_id' => '1',
                'name' => 'pdf',
                'path' => 'pdf'
            ],
        ];
        foreach ($internship_certificate as $row){
            InternshipCertificate::create($row);
        }
    }
}

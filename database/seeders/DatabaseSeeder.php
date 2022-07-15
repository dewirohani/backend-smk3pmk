<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LevelSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(PassportInstallSeeder::class);
        $this->call(InternshipPlaceSeeder::class);
        $this->call(PeriodStatusSeeder::class);
        $this->call(PeriodSeeder::class);
        $this->call(InternshipSubmissionStatusSeeder::class);
        $this->call(LogbookStatusSeeder::class);
        $this->call(InternshipReportStatusSeeder::class);
        // $this->call(AttendanceSeeder::class);
        // $this->call(InternshipSubmissionSeeder::class);
        // $this->call(InternshipPlacementSeeder::class);
    }
}

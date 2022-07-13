<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_placements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_submission_id')->constrained('internship_submissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained('grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('major_id')->constrained('majors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('periods')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('internship_place_id')->constrained('internship_places')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_placements');
    }
}

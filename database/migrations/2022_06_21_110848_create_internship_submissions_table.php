<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained('grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('major_id')->constrained('majors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('periods')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('internship_place_id')->constrained('internship_places')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('internship_submission_statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('file'); 
            $table->unsignedBigInteger('authorized_by')->nullable();
            $table->foreign('authorized_by')->references('id')->on('teachers')->onUpdate('cascade')->onDelete('cascade');          
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
        Schema::dropIfExists('internship_submissions');
    }
}

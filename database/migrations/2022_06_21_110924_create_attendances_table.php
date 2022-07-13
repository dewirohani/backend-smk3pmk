<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onUpdate('cascade')->onDelete('cascade');           
            $table->foreignId('teacher_id')->constrained('teachers')->onUpdate('cascade')->onDelete('cascade');           
            $table->date('date');     
            $table->time('time_in');     
            // $table->time('time_out');     
            $table->string('description')->nullable();    
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
        Schema::dropIfExists('attendances');
    }
}

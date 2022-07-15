<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',        
        'teacher_id',
        'date',
        'time_in',
        'time_out',
        'description',
        
    ];

    protected $with = [
        'student',
        'teacher'
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
} 

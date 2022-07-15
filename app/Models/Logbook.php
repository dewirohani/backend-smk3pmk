<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'attendance_id',
        'student_id',
        'teacher_id',
        'date',      
        'activity',
        'status_id',
        'file',
    ];

    protected $with = [
        'attendance',
        'student',
        'teacher',
        'logbookStatuses',
    ];

    public function attendance(){
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function logbookStatuses(){
        return $this->belongsTo(LogbookStatus::class, 'status_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'internship_placement_id',
        'student_id',
        'teacher_id',
        'file',
        'description',
        'status_id',
    ];
    protected $with = [
        'internshipPlacement',        
        'student',
        'teacher',
        'status',
        
    ];


    public function internshipPlacement()
    {
        return $this->belongsTo(internshipPlacement::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function status()
    {
        return $this->belongsTo(InternshipReportStatus::class);
    }
}
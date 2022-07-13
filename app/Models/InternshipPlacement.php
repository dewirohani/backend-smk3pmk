<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipPlacement extends Model
{
    use HasFactory;
    protected $fillable = [
        'internship_submission_id',
        'student_id',
        'teacher_id',
        'grade_id',
        'major_id',
        'period_id',
        'internship_place_id',
        
        
    ];

    protected $with = [
        'internshipSubmission',
        'internshipPlace',
        'teacher',
        'student',
        'major',
        'grade',
        'period',
  
    ];

    public function internshipSubmission(){
        return $this->belongsTo(InternshipSubmission::class, 'internship_submission_id');
    }
    public function internshipPlace(){
        return $this->belongsTo(InternshipPlace::class, 'internship_place_id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function major(){
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function grade(){
        return $this->belongsTo(Grade::class, 'grade_id');
    }
    public function period(){
        return $this->belongsTo(Period::class, 'period_id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'student_id',   
        'grade_id',
        'major_id',
        'period_id',
        'internship_place_id',
        'status_id',
        'file',
        'authorized_by'
    ];

    protected $with = [
        
        'student',
        'grade',
        'major',
        'period',
        'internshipPlace',
        'internshipSubmissionStatus',
    ];

   
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function grade(){
        return $this->belongsTo(Grade::class, 'grade_id');
    }
    
    public function major(){
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function period(){
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function internshipPlace(){
        return $this->belongsTo(InternshipPlace::class, 'internship_place_id');
    }
    public function internshipSubmissionStatus(){
        return $this->belongsTo(InternshipSubmissionStatus::class, 'status_id');
    }
    public function authorizer()
    {
        return $this->belongsTo('App\Models\Teacher', 'authorized_by','id');
    }
}

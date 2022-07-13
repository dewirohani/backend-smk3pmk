<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipPlace extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'districts',
        'city',
        'mentor',
        'teacher_id',
        'phone',
        'quota',
        'time_in',
        'time_out',
    ];
    protected $with = [
        'teacher'
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

}

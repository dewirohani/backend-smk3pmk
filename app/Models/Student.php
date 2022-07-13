<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'name',
        'grade_id',
        'major_id',
        'address',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'religion',
        'phone',
        'year_of_entry',
        'user_id',
    ];

    protected $with = [
        'user',
        'grade',
        'major'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grade(){
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function major(){
        return $this->belongsTo(Major::class, 'major_id');
    }
}

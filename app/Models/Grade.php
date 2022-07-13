<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'major_id',
        'description',
    ];

    protected $with = [
        'major'
    ];

    public function major(){
        return $this->belongsTo(Major::class, 'major_id');
    }
}

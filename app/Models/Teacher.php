<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip',
        'name',
        'address',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'religion',
        'phone',
        'user_id'
    ];
    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

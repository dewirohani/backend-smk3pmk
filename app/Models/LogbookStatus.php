<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];

}

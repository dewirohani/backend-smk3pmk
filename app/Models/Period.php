<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_periode',
        'start_date',
        'end_date',
        'status_id'
    ];

    protected $with = [
        'periodStatuses',
    ];

    public function periodStatuses(){
        return $this->belongsTo(PeriodStatus::class, 'status_id');
    }
}

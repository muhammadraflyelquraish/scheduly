<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'matkul_id',
        'class_id',
        'code',
        'sks',
        'day',
        'start_time',
        'end_time',
        'room'
    ];

    function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }

    function class()
    {
        return $this->belongsTo(Classes::class);
    }
}

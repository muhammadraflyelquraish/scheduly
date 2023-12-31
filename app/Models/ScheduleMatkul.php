<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleMatkul extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'matkul_id'];

    function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function classes()
    {
        return $this->hasMany(ScheduleMatkulClass::class, 'schedule_matkul_id', 'id');
    }
}

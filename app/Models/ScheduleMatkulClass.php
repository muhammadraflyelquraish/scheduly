<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleMatkulClass extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_matkul_id', 'class_id', 'sks', 'day', 'hour', 'room'];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'academic_year',
        'type_periode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail(): HasMany
    {
        return $this->hasMany(ScheduleDetail::class, 'schedule_id', 'id');
    }

    // public function matkuls(): HasMany
    // {
    //     return $this->hasMany(ScheduleMatkul::class, 'schedule_id', 'id');
    // }
}

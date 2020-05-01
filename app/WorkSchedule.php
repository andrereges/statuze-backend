<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $table = 'work_schedules';
    protected $fillable = ['name', 'begin', 'end'];
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getBeginAttribute()
    {
        return date('H:i', strtotime($this->attributes['begin']));
    }

    public function getEndAttribute()
    {
        return date('H:i', strtotime($this->attributes['end']));
    }
}

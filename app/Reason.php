<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = 'reasons';
    protected $fillable = ['name, expected_return'];
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'status_reasons', 'reason_id');
    }

    public function getExpectedReturnAttribute()
    {
        if ($this->attributes['expected_return']) {
            return date('H:i', strtotime($this->attributes['expected_return']));
        }
    }
}

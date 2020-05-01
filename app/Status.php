<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';
    protected $fillable = ['name', 'color'];
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function reasons()
    {
        return $this->belongsToMany(Reason::class, 'status_reasons', 'status_id');
    }
}

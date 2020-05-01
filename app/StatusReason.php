<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusReason extends Model
{
    const INVISIVEL_OUTROS = 10;

    protected $table = 'status_reasons';
    protected $fillable = ['status_id', 'reason_id'];
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at', 'status_id', 'reason_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    const ANONYMOUS_IMAGE = 'public/static/anonymous.jpg';
    protected $table = 'images';
    protected $fillable = ['name', 'extension'];
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

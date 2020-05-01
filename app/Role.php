<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const USER = 3;
    protected $table = 'roles';
    protected $fillable = ['name'];
    public $timestamps = false;
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id');
    }
}

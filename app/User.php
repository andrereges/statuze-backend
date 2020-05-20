<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const PATH_IMAGE = 'public/user/profile_pictures/';
    const ADMINISTRADOR_ID = 1;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'birth', 'email', 'password', 'people_id', 'work_schedule_id', 'department_id', 'image_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email_verified_at', 'created_at', 
        'updated_at', 'department_id', 'work_schedule_id',
        'pivot',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id');
    }

    public function imageUrl()
    {
        $imageUrl = Image::ANONYMOUS_IMAGE;

        if ($this->image) {
            $imageUrl = sprintf('%s%s', $this->getImagePath(), $this->image->name);
        }

        return App::make('url')->to(Storage::url($imageUrl));
    }

    public function userStatusReasons()
    {
        return $this->belongsToMany(StatusReason::class, 'user_statuses', 'user_id');;
    }

    public function userStatuses()
    {
        return $this->hasMany(UserStatus::class, 'user_id')
            ->latest('id')
            ->take(1)
            ->with('statusReason');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getBirthAttribute()
    {
        if ($this->attributes['birth']) {
            return date('Y-m-d', strtotime($this->attributes['birth']));
        }
    }

    public function getNameInParts(int $numberOfParts = 0)
    {
        if ($numberOfParts <= 0)
            return $this->name;

        $partsName = explode(' ', $this->name);
        
        $nameInParts = [];
        foreach($partsName as $key => $part) {
            $nameInParts[] = $part;

            if (($numberOfParts - 1) == $key)
                return implode(' ', $nameInParts);                
        }

        return implode(' ', $nameInParts);
    }

    public function getImagePath()
    {
        return self::PATH_IMAGE;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function delete()
    {
        $this->userStatuses()->delete();

        if (isset($this->image) && Storage::exists($this->getImagePath().$this->image->name)) 
            Storage::delete($this->getImagePath().$this->image->name);
        
        if ($this->image)
        $this->image()->delete();
        
        return parent::delete();
    }

    public static function search($filters)
    {
        return User::where(function ($query) use ($filters) {
            $user_ids = isset($filters['users']) ? array_map('intval', $filters['users']) : [];
            $department_ids = isset($filters['departments']) ? array_map('intval', $filters['departments']) : [];
            $work_schedule_ids = isset($filters['workSchedules']) ? array_map('intval', $filters['workSchedules']) : [];
            
            if ($user_ids)
                $query->whereIn('id', $user_ids);

            if ($department_ids)
                $query->whereIn('department_id', $department_ids);

            if ($work_schedule_ids)
                $query->whereIn('work_schedule_id', $work_schedule_ids);
        })->orderBy('name', 'ASC');
    }
}

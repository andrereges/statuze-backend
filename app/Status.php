<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

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

    public static function statusWithUsers($userLoggedFirstList = false)
    {
        $statuses = Status::all();
        $users = User::orderBy('name', 'ASC')->get();
        $userLoggedId = JWTAuth::user()->id;

        $statusWithUsers = [];
        foreach ($statuses as $status) {
            $statusWithUsers[] =
                [
                    'id' => $status->id,
                    'name' => $status->name,
                    'color' => $status->color,
                    'users' => []
                ]
            ;
        }

        foreach ($users as $user) {
            $userStatusId = $user->userStatuses->last()->statusReason->status->id;

            foreach ($statusWithUsers as $key => $statusWithUser) {
                if (($userStatusId == $statusWithUser['id']) && $user->id != User::ADMINISTRADOR_ID) {
                    $userStatus = [
                        'id' => $user->id,
                        'nickName' => $user->getNameInParts(2),
                        'name' => $user->name,
                        'email' => $user->email,
                        'birth' => $user->birth,
                        'department' => $user->department,
                        'workSchedule' => $user->workSchedule,
                        'roles' => $user->roles,
                        'image' => $user->imageUrl(),
                        'user_status' => [
                            'id' => $user->userStatuses->last()->id,
                            'from' => $user->userStatuses->last()->from,
                            'to' => $user->userStatuses->last()->to,
                            'note' => $user->userStatuses->last()->note,
                            'reason' => $user->userStatuses->last()->statusReason->reason
                        ]
                    ];

                    if ($user->id == $userLoggedId && $userLoggedFirstList)
                        array_unshift($statusWithUsers[$key]['users'], $userStatus);
                    else
                        array_push($statusWithUsers[$key]['users'], $userStatus);
                }
            }
        }

        return $statusWithUsers;
    }
}

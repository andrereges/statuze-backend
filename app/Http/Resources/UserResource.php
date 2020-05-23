<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nickName' => $this->getNameInParts(1),
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active,
            'gender' => $this->gender,
            'birth' => $this->birth,
            'department' => $this->department,
            'workSchedule' => $this->workSchedule,
            'roles' => $this->roles,
            'image' => $this->imageUrl(),
            'user_status' => $this->userStatuses->last()->statusReason
        ];
    }
}

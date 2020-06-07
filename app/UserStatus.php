<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'user_statuses';
    protected $fillable = ['user_id', 'status_reason_id', 'from', 'to', 'note'];
    public $timestamps = false;
    protected $hidden = ['user_id', 'status_reason_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class)
            ->with(['userStatuses', 'department', 'workSchedule']);
    }

    public function statusReason()
    {
        return $this->belongsTo(StatusReason::class)
            ->with(['status', 'reason']);
    }

    public function getFromAttribute()
    {
        if ($this->attributes['from']) {
            return date('d/m/Y H:i', strtotime($this->attributes['from']));
        }
    }

    public function getToAttribute()
    {
        if ($this->attributes['to']) {
            return date('d/m/Y H:i', strtotime($this->attributes['to']));
        }
    }

    public function setToAttribute($value)
    {
        if (is_null($value) && $this->statusReason->reason->expected_return) {
            $this->attributes['to'] =
                $this->setDefaultTime($this->statusReason->reason->expected_return);
            return;
        }

        throw_if(
            !is_null($value) && (strtotime('-1 seconds', strtotime(now())) >= strtotime($value)),
            new Exception('A data prevista para o retorno deve ser maior que a data atual', 400)
        );

        $this->attributes['to'] = $value;
    }

    private function setDefaultTime($value)
    {
        if (is_null($value)) {
            $this->attributes['to'] = $value;
            return;
        }

        $timeReturn = strtotime($value);
        $hours = date('H', $timeReturn);
        $minutes = date('i', $timeReturn);
        $date = date("Y-m-d H:i:s", strtotime("+$hours hours, +$minutes minutes", time()));

        return $date;
    }

    public static function userStatusByFrom(int $userId, $date)
    {
        return UserStatus::with('statusReason')
            ->where(['user_id' => $userId])
            ->whereDate('from', '=', date($date))
            ->orderBy('from', 'ASC')
            ->get();
    }
}

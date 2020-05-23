<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkScheduleCollection;
use App\WorkSchedule;

class WorkScheduleController extends Controller
{
    public function index()
    {
        return new WorkScheduleCollection(WorkSchedule::all());
    }
}

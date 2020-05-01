<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusCollection;
use App\Status;

class StatusController extends Controller
{
    public function index()
    {
        return new StatusCollection(Status::all());
    }
}

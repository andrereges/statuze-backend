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

    public function statusWithUsers()
    {
        try {
            return response()->json([
                'type' => 'success',
                'data' => Status::statusWithUsers(),
                'message' => 'All right'
            ], 200)->header('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'type' => 'error',
                    'data' => null,
                    'message' => $exception->getMessage()
                ], 404)
                ->header('Content-Type', 'application/json');
        }
    }    
}

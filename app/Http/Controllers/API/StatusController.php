<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\{ StatusCollection, StatusResource };
use App\Status;

class StatusController extends Controller
{
    public function index()
    {
        return new StatusCollection(Status::all());
    }

    public function show($id)
    {
        try {
            return response()->json([
                'type' => 'success',
                'data' => new StatusResource(Status::findOrFail($id)),
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

    public function statusWithUsers()
    {
        return Status::statusWithUsers(true);
        try {
            return response()->json([
                'type' => 'success',
                'data' => Status::statusWithUsers(true),
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

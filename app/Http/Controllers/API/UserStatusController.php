<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStatusResquest;
use App\Http\Resources\{ UserStatusCollection, UserStatusResource};
use App\{ StatusReason, UserStatus};
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserStatusCollection(
            UserStatus::distinct(['user_id'])
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UserStatusResquest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStatusResquest $request)
    {
        try {           
            $oldUserStatus = UserStatus::where(['user_id' => JWTAuth::user()->id])
                ->latest('id')->firstOrFail();

            $statusReason = StatusReason::where(
                [
                    'status_id' => $request->status,
                    'reason_id' => $request->reason
                ]
            )->firstOrFail();

            $oldUserStatus->to = date('Y-m-d H:i:s');
            
            $newUserStatus = new UserStatus();
            $newUserStatus->user_id = $oldUserStatus->user->id;
            $newUserStatus->status_reason_id = $statusReason->id;

            $newUserStatus->from = date('Y-m-d H:i:s');
            $newUserStatus->to = $request->to;
            $newUserStatus->note = $request->note;

            $oldUserStatus->update();
            $newUserStatus->saveOrFail();   

            return response()->json([
                'type' => 'success',
                'data' => $newUserStatus,
                'message' => 'All right'
            ], 200)->header('Content-Type', 'application/json');
        } catch (Exception $exception) {
            return response()
                ->json([
                    'type' => 'error',
                    'data' => null,
                    'message' => $exception->getMessage(),
                ], 404)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $userStatus = UserStatus::where(['user_id' => $id])
                ->latest('id')->firstOrFail();

            return response()->json([
                'type' => 'success',
                'data' => new UserStatusResource($userStatus),
                'message' => 'All right'
            ], 200)->header('Content-Type', 'application/json');
        } catch (Exception $exception) {
            return response()
                ->json([
                    'type' => 'error',
                    'data' => null,
                    'message' => $exception->getMessage()
                ], 404)
                ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $userStatus = UserStatus::where(['user_id' => JWTAuth::user()->id])
                ->latest('id')->firstOrFail();

            $userStatus->to = $request->to;
            $userStatus->note = $request->note;
            $userStatus->update();

            return response()->json([
                'type' => 'success',
                'data' => $userStatus,
                'message' => 'All right'
            ], 200)->header('Content-Type', 'application/json');
        } catch (Exception $exception) {
            return response()
                ->json([
                    'type' => 'error',
                    'data' => null,
                    'message' => $exception->getMessage()
                ], 404)->header('Content-Type', 'application/json');
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserResquest;
use App\Http\Resources\{ UserCollection, UserResource };
use App\{ User, Image, Role, StatusReason };
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{ DB, Storage };
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::orderBy('name', 'ASC')->paginate());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $filters)
    {
        try {
            $users = User::search($filters->all())->paginate();
            return new UserCollection($users);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserResquest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->active = $request->active;
            $user->gender = $request->gender;
            $user->birth = date($request->birth);
            $user->password = $request->password;
            $user->work_schedule_id = $request->work_schedule;
            $user->department_id = $request->department;

            $user->saveOrFail();

            $user->userStatusReasons()->sync(StatusReason::INVISIVEL_OUTROS);

            if ($request->roles)
                $user->roles()->sync($request->roles);
            else
                $user->roles()->sync(Role::USER);

            if ($request->file('image')) {
                $image = new Image();
                $image->extension = $request->file('image')->extension();
                $image->name = Str::random(20).'.'.$image->extension;
                $image->user_id = $user->id;

                if($image->saveOrFail()) {
                    Storage::putFileAs(
                        $user->getImagePath(),
                        $request->file('image'),
                        $image->name
                    );
                }
            }

            return response()->json([
                'type' => 'success',
                'data' => $user,
                'message' => 'All right'
            ], 200)->header('Content-Type', 'application/json');
        } catch (Exception $exception) {
            DB::rollback();
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                    'object' => null,
                ], 500)->header('Content-Type', 'application/json');
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
            return response()->json([
                'type' => 'success',
                'data' => new UserResource(User::with(['userStatuses'])->findOrFail($id)),
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $user = JWTAuth::user();

            if ($request->name)
                $user->name = $request->name;
            if ($request->email)
                $user->email = $request->email;
            if ($request->active)
                $user->active = $request->active;
            if ($request->gender)
                $user->gender = $request->gender;
            if ($request->birth)
                $user->birth = $request->birth;
            if ($request->password)
                $user->password = $request->password;
            if ($request->work_schedule)
                $user->work_schedule_id = $request->work_schedule;
            if ($request->department)
                $user->department_id = $request->department;
            if ($request->roles)
                $user->roles()->sync($request->roles);

            if ($request->file('image')) {
                if (isset($user->image->name ) && Storage::exists($user->getImagePath().$user->image->name))
                    Storage::delete($user->getImagePath().$user->image->name);

                if ($user->image)
                    $user->image->delete();

                $image = new Image();
                $image->extension = $request->file('image')->extension();
                $image->name = Str::random(20).'.'.$image->extension;
                $image->user_id = $user->id;

                Storage::putFileAs(
                    $user->getImagePath(),
                    $request->file('image'),
                    $image->name
                );

                $user->image()->save($image);
            }

            $user->update();
            $user = User::findOrFail($user->id);

            return response()->json([
                'type' => 'success',
                'data' => new UserResource($user),
                'message' => 'Usuário atualizado com sucesso'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'type' => 'success',
                'data' => $user,
                'message' => 'All right'
            ], 200)->header('Content-Type', 'application/json');
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json([
                    'type' => 'error',
                    'data' => null,
                    'message' => $exception->getMessage()
                ], 404)->header('Content-Type', 'application/json');
        }
    }
}

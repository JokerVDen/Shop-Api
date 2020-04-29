<?php

namespace App\Http\Controllers\User;

use App\Exceptions\User\AdminNotVerifiedException;
use App\Exceptions\User\UpdateNotDifferentValuesException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->service->getAllUsers();
        return response()->json(['data' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->service->storeUser($request->all());
        return  response()->json(['data'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $updatedUser = $this->service->updateUser($user, $request->all());
        } catch (AdminNotVerifiedException $e) {
            return response()->json(
                [
                    'error' => __('user/error.only_verified_user_can_modify_the_admin_field'),
                    'code' => 422
                ], 422);
        } catch (UpdateNotDifferentValuesException $e) {
            return response()->json(
                [
                    'error' => __('user/error.need_to_specify_a_different_values'),
                    'code' => 422
                ], 422);
        }

        return response()->json(['data' => $updatedUser]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['data' => $user]);
    }
}

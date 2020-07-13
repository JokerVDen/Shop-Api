<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * @var UserService
     */
    private $service;

    public function __construct(UserService $service)
    {
        $this->middleware('client.credentials')->only(['store', 'resend']);
        $this->middleware('auth:api')->except(['store', 'verify', 'resend']);
        $this->middleware('transform.resource.input:' . UserResource::class)
            ->only(['store', 'update']);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index()
    {
        $users = $this->service->getAllUsers();
        return $this->jsonAll($users);
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
        return $this->jsonOne($user);
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
        return $this->jsonOne($user, 201);
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
        $updatedUser = $this->service->updateUser($user, $request->all());

        return $this->jsonOne($updatedUser);
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
        return $this->jsonOne($user);
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($token)
    {
        $verified = $this->service->verifyUser($token);
        if (!$verified)
            abort(404);

        return $this->showMessage(__('The account has been verified successful!'));
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(User $user)
    {
        $this->service->resendVerificationEmail($user);

        return $this->showMessage(__('The verification email has been resend!'));
    }

}

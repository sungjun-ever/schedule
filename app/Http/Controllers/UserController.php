<?php

namespace App\Http\Controllers;

use App\DTOs\User\UpdateUserDto;
use App\DTOs\User\StoreUserDto;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResources;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function __construct(
        protected UserService $userService
    )
    {
    }

    public function my(): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => $this->userService->findUserById(auth()->user()->id)
        ]);
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json([
            'message' => 'success',
            'data' => UserResources::collection($users)
        ]);
    }

    public function show(int $userId): JsonResponse
    {
        $user = $this->userService->findUserById($userId);
        return response()->json([
            'message' => 'success',
            'data' => new UserResources($user)
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->userService->storeUser(new StoreUserDto(
            name: $request->post('name'),
            email: $request->post('email'),
            password: $request->post('password'),
            level: $request->post('level'),
            teamId: $request->post('teamId') ?: null
        ));

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function update(UpdateUserRequest $request, $userId): JsonResponse
    {
        $password = $request->post('password') && $request->post('passwordConfirmation') ?
            Hash::make($request->post('password')) : null;

        $userDto = new UpdateUserDto(
            name: $request->post('name'),
            email: $request->post('email'),
            password: $password,
            level: $request->post('level'),
            teamId: $request->post('teamId'),
        );

        $this->userService->updateUser($userId, $userDto);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function delete(int $userId): JsonResponse
    {
        $this->userService->deleteUser($userId);

        return response()->json([
            'message' => 'success',
        ]);
    }
}

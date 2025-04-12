<?php

namespace App\Http\Controllers;

use App\DTOs\User\UpdateUserDto;
use App\DTOs\User\StoreUserDto;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
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

    public function testUser():void
    {
        $this->userService->storeUser(new StoreUserDto(
            name: "TEST",
            email: "test@test.com",
            password: '123456'
        ));
    }

    public function my(): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => $this->userService->getUserById(auth()->user()->id)
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => $this->userService->getAllUsers()->toArray()
        ]);
    }

    public function show(int $userId): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => $this->userService->getUserById($userId)
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

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $password = $request->post('password') && $request->post('passwordConfirmation') ?
            $request->post('password') : null;

        $userDto = new UpdateUserDto(
            name: $request->post('name'),
            email: $request->post('email'),
            password: $password,
            level: $request->post('level'),
            teamId: $request->post('teamId'),
        );

        $this->userService->updateUser($request->post('id'), $userDto);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $this->userService->deleteUser($request->post('id'));

        return response()->json([
            'message' => 'success',
        ]);
    }
}

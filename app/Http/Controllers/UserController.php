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

    public function show(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            throw new ValidationException($validated);
        }

        return response()->json([
            'message' => 'success',
            'data' => $this->userService->getUserById($validated['id'])
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $userDto = new StoreUserDto(
            name: $request->post('name'),
            email: $request->post('email'),
            password: $request->post('password'),
            teamId: $request->post('teamId')
        );

        $this->userService->storeUser($userDto);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $userDto = new UpdateUserDto(
            name: $request->post('name'),
            email: $request->post('email'),
            teamId: $request->post('teamId') ?? null,
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

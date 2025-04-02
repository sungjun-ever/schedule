<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
}

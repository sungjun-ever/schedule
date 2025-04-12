<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function report(): void
    {

    }

    public function render($request)
    {
        return response()->json([
            'status' => 'error',
            'message' => '사용자를 찾을 수 없습니다.'
        ]);
    }
}

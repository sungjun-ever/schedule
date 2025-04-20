<?php

namespace App\Exceptions;

use Exception;

class CreateResourceFailedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'status' => 'error',
            'message' => '팀 생성에 실패했습니다.'
        ]);
    }
}

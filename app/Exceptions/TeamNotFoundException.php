<?php

namespace App\Exceptions;

use Exception;

class TeamNotFoundException extends Exception
{
    public function render()
    {
        return response()->json([
            'status' => 'error',
            'message' => '존재하지 않는 팀입니다.'
        ], 404);
    }
}

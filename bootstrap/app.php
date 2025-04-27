<?php

use App\Exceptions\CreateResourceFailedException;
use App\Exceptions\UpdateResourceFailedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404);
        });

        $exceptions->render(function (CreateResourceFailedException $e) {
            return response()->json([
               'status' => 'error',
               'message' => '생성에 실패했습니다.',
            ]);
        });

        $exceptions->render(function (UpdateResourceFailedException $e) {
            return response()->json([
               'status' => 'error',
               'message' => '수정에 실패했습니다.',
            ]);
        });

        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->validator->errors(),
            ]);
        });
    })->create();

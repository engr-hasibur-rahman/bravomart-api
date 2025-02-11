<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    public function render($request, Throwable $exception)
    {

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'You must be logged in to access this resource.',
                'error' => 'Unauthorized'
            ], 401);
        }


        if ($exception instanceof RouteNotFoundException) {
            return response()->json([
                'message' => 'The route you are trying to access is not defined.',
                'error' => 'Route Not Found'
            ], 404);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'You are not authenticated. Please log in.',
            'error' => 'Unauthenticated'
        ], 401);
    }
}

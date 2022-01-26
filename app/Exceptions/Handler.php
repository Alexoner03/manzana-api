<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (UnauthorizedException $e) {
            return response()->json([
                "message" => $e->getMessage()
            ],401);
        });

        $this->renderable(function (ModelNotFoundException $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "errors" => [
                    "model" => [
                        "la entidad buscada no existe"
                    ]
                ]
            ],422);
        });

        $this->renderable(function (UnprocessableEntityHttpException $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "errors" => [
                    "model" => [
                        "la comida ya existe en la lista de usuario"
                    ]
                ]
            ],422);
        });
    }
}

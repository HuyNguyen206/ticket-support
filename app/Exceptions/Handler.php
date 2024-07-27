<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $statusCode = match (true) {
          $e instanceof ModelNotFoundException => Response::HTTP_NOT_FOUND,
          $e instanceof AuthorizationException => Response::HTTP_FORBIDDEN,
          $e instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };

        return $this->error([
            'type' => class_basename($e),
            'status' => 0,
            'message' => $statusCode === Response::HTTP_UNPROCESSABLE_ENTITY ? $e->errors(): $e->getMessage()
        ] + (app()->isLocal() ? ['source' => sprintf('Line %s: at %s', $e->getLine(), $e->getFile())] : []), $statusCode);
    }
}

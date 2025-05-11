<?php

namespace App\Providers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ExceptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ExceptionHandler::class, function ($app) {
            return new class($app) extends \Illuminate\Foundation\Exceptions\Handler
            {
                public function render($request, \Throwable $e): Response
                {
                    if ($e instanceof RouteNotFoundException) {
                        return response()->json([
                            'error' => 'Internal server error.',
                            'message' => $e->getMessage(),
                        ], 500);
                    }

                    if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                        return response()->json([
                            'error' => 'Something went wrong.',
                            'message' => $e->getMessage(),
                        ], 500);
                    }

                    if ($e instanceof AuthenticationException || $e instanceof AuthorizationException) {
                        return response()->json([
                            'error' => 'Unauthorized Access.',
                            'message' => $e->getMessage(),
                        ], 401);
                    }

                    if ($e instanceof ValidationException) {
                        return response()->json([
                            'error' => 'Validation failed.',
                            'details' => $e->errors(),
                        ], 422);
                    }

                    return parent::render($request, $e);
                }

                protected function shouldReturnJson($request, \Throwable $e): bool
                {
                    return true;
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

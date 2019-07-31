<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            if ($request->wantsJson()) {
                $errors = [];
                $errors['message'] = "Not Found";
                return response()->json(['data' => [], 'errors' => $errors], 404);
            }
            return response()->view('errors.404', [], 404);
        } else if ($exception instanceof NotFoundHttpException) {
            if ($request->wantsJson()) {
                $errors = [];
                $errors['message'] = "Route Not Found";
                return response()->json(['data' => [], 'errors' => $errors], 404);
            }
            return response()->view('errors.404', [], 404);
        } else if ($exception instanceof ClientException) {

            if ($request->wantsJson()) {
                $errors = [];
                $errors['message'] = "Not Found";
                return response()->json(['data' => [], 'errors' => $errors], 404);
            }
            $errorsData = \GuzzleHttp\json_decode($exception->getResponse()->getBody());

            dd($errorsData);

            $errors['status'] = $errorsData->error->status;
            $errors['message'] = $errorsData->error->message;

            return response()->view('errors.422', compact('errors'), 422);
        } else {
            if ($request->wantsJson()) {
                $errors = [];
                $errors['message'] = $exception->getMessage();
                return response()->json(['data' => [], 'errors' => $errors], $this->getStatusCode($exception));
            }

            return parent::render($request, $exception);
        }
    }

    protected function getStatusCode(Exception $e)
    {
        if ($e instanceof HttpException || method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        }

        if ($e instanceof ModelNotFoundException) {
            return SymfonyResponse::HTTP_NOT_FOUND;
        }

        return SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
    }
}

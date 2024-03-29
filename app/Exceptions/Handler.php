<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\UnauthorizedException;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        UnauthorizedException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(\Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Exception $e)
    {
        $http_code = 500;
        $error_code = 'internal_server_error';
        $error_message = null;

        $meta = [];

        if ($e instanceof ValidationException) {
            return response()->json([
                'meta' => [
                    'code' => 422,
                    'error' => 'validation',
                ],
                'data' => $e->errors(),
            ], 422, ['Content-Type' => 'application/json']);

        } elseif ($e instanceof ModelNotFoundException) {
            $http_code = 404;
            $error_code = $this->formatModelName($e->getModel()) . '_not_found';

        } elseif ($e instanceof NotFoundHttpException) {
            $http_code = 404;
            $error_code = $e->getMessage() ?: 'not_found';

        } elseif ($e instanceof UnauthorizedException) {
            $http_code = 401;
            $error_code = 'unauthorized';
            $meta['error_message'] = $e->getMessage();

        } elseif ($e instanceof HttpException) {
            $http_code = $e->getStatusCode();
            $error_code = $e->getMessage() ?: 'http';
        }

        if ($http_code === 500 and env('APP_DEBUG') === true) {
            return env('APP_SHOW_WHOOPS_ERROR', false) ? $this->renderExceptionWithWhoops($e) : $e->__toString();
        }

        $meta['code'] = $http_code;
        $meta['error'] = $error_code;

        if (empty($meta['error_message']) and $error_msg = config("errors.$error_code")) {
            $meta['error_message'] = $error_msg;
        }

        return response()->json($meta, $http_code, ['Content-Type' => 'application/json']);
    }

    private function formatModelName($model)
    {
        $name = explode('\\', $model);

        return strtolower(end($name));
    }

    protected function renderExceptionWithWhoops(\Exception $e)
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        return response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
}

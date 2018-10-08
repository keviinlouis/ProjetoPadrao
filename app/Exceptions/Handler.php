<?php

namespace App\Exceptions;

use App\Http\Resources\ValidationResource;
use DB;
use Exception;
use http\Exception\InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Reliese\Coders\Model\Model;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

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
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {

        if ($request->isJson() || $request->expectsJson()) {
            return $this->makeResponseJson($request, $exception);
        }

        if($exception instanceof ValidationException){
            return back()->withErrors($exception->validator)->withInput();
        }

        return parent::render($request, $exception);
    }

    public function makeResponseJson(Request $request, Exception $exception)
    {
        $production = env('APP_ENV') == 'production';

        if ($exception instanceof ValidationException) { // Exception de validator
            return (new ValidationResource($exception))->response();
        }
        if($exception instanceof WrongPasswordException){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => [
                    $exception->getInput() => [
                        $exception->getMessage()
                    ]
                ]
            ], $exception->getCode());
        }
        $code = $this->getCodeException($exception);

        $headers = [];

        //Começo de toda exception inesperada
        $response = [
            'success' => false,
            'message' => __($exception->getMessage())
        ];

        if(method_exists($exception, 'getData')){
            $response['data'] = $exception->getData();
        }

        if ($exception instanceof TokenBlacklistedException) {
            $code = Response::HTTP_UNAUTHORIZED;
            $response['message'] = __('Token expirou');
            $response['error'] = 'token_expired';
            $headers['WWW-Authenticate'] = 'jwt-auth';
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $code = Response::HTTP_BAD_REQUEST;
            $response['message'] = __('Método não permitido');
            $response['url'] = $request->getUriForPath('/' . $request->path());
            $response['method'] = $request->getMethod();
            $headers = $exception->getHeaders();
        }

        if ($exception instanceof AuthenticationException) {
            $code = Response::HTTP_UNAUTHORIZED;
            $response['message'] = __('Requisição não autorizada');
            $response['error'] = 'unauthorized';
            $headers = $exception->getHeaders();
        }
        if ($exception instanceof UnauthorizedHttpException) {
            $headers = $exception->getHeaders();
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = explode('\\', $exception->getModel());
            $response['message'] = __("Recurso não encontrado");
            $response['data'] = end($model);
            $code = Response::HTTP_NOT_FOUND;
        }

        if ($exception instanceof NotFoundHttpException) {
            $response['message'] = __("Recurso não encontrado");
            $response['url'] = $request->getUriForPath('/' . $request->path());
            $response['method'] = $request->getMethod();
            $code = Response::HTTP_NOT_FOUND;
            $headers = $exception->getHeaders();
        }

        if ($exception instanceof ReflectionException) {
            $response['message'] = __("Erro Interno");
            $response['error'] = $exception->getMessage();
            $response['url'] = $request->getUriForPath('/' . $request->path());
            $response['method'] = $request->getMethod();
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($exception instanceof \InvalidArgumentException) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        //Exception para desenvolvimento
        if (!$production && $exception instanceof QueryException) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response['error'] = $exception->getPrevious()->getMessage();
            $response['query'] = $exception->getSql();
            $response['bindings'] = $exception->getBindings();
        }

        if ($exception instanceof ReflectionException) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($exception instanceof FatalThrowableError) {
            $response['message'] = $exception->getMessage();
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if (!$production && $code == Response::HTTP_INTERNAL_SERVER_ERROR) {
            $response['url'] = $request->getUriForPath('/' . $request->path());
            $response['method'] = $request->getMethod();
            $response['line'] = $exception->getLine();
            $response['file'] = $exception->getFile();
            $response['trace'] = $exception->getTrace();
        }

        return response()->json($response, $code, $headers);
    }

    public function getCodeException(Exception $exception)
    {
        return $exception->getCode() != 0 && !is_string($exception->getCode()) ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}

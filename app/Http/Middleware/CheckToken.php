<?php

namespace App\Http\Middleware;

use Config;
use Illuminate\Http\Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class CheckToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        $this->checkForToken($request); // Ver se tem o token
        if($guard){
            Config::set('auth.defaults.guard', $guard);
        }
        try {
            $id = $this->auth->parseToken()->getPayload()['sub'];
            if (!auth()->guard($guard)->onceUsingId($id)) { // Check user not found. Check token has expired.
                throw new UnauthorizedHttpException('jwt-auth', 'Usuario não encontrado'); //Se der problema com o token, virá um header chamado WWW-Authenticate com o valor de jwt-auth
            }
            return $next($request); // Se o usuario for autenticado e logado com token válido, continua request

        } catch (TokenExpiredException $t) { // Token expirado, usuario não logado
            $payload = $this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray(); // Pega os dados do token para autenticação

            $refreshed = JWTAuth::refresh(JWTAuth::getToken()); // Faz refresh do token

            auth()->onceUsingId($payload['sub']); // Autentica pelo ID

            $response = $next($request); // Pega a request

            $response->header('new_token', $refreshed); // Adiciona o header com o novo token

            return $response; // Responde com o novo token no header

        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token Inválido', $e, Response::HTTP_UNAUTHORIZED); //Se der problema com o token, virá um header chamado WWW-Authenticate com o valor de jwt-auth
        }
    }
}
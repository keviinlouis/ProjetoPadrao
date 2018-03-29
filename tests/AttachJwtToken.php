<?php
namespace Tests;
use App\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;

trait AttachJwtToken
{
    /**
     * @var User
     */
    protected $loginUser = null;
    /**
     * @param $user
     * @return $this
     */
    public function loginAsWithJwt($user)
    {
        $this->loginUser = $user;
        return $this;
    }
    /**
     * @return string
     */
    protected function getJwtToken()
    {
        return JWTAuth::fromSubject($this->loginUser);
    }
    /**
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        if ($this->loginUser) {
            $server = $this->attachToken($server);
        }
        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    /**
     * @param array $server
     * @return string
     */
    protected function attachToken(array $server)
    {
        return array_merge($server, $this->transformHeadersToServerVars([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ]));
    }
}
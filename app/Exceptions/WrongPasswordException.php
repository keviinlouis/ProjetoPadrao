<?php
/**
 * Created by PhpStorm.
 * User: devmaker
 * Date: 30/08/18
 * Time: 19:11
 */

namespace App\Exceptions;


use Throwable;

class WrongPasswordException extends \Exception
{
    private $input;

    public function __construct(string $input = 'senha', string $message = null, int $code = 400, Throwable $previous = null)
    {
        $this->input = $input;

        $message = $message ?? __('auth.failed');

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getInput(): string
    {
        return $this->input;
    }

}

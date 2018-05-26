<?php
/**
 * Created by PhpStorm.
 * User: DevMaker BackEnd
 * Date: 22/05/2018
 * Time: 16:18
 */

namespace App\Moip\Exceptions;


use Illuminate\Http\Response;
use Moip\Exceptions\Error;
use Moip\Exceptions\ValidationException;
use Throwable;

class MoipValidatorException extends \Exception
{
    /**
     * @var \Illuminate\Support\Collection|Error[]
     */
    private $errors;

    public function __construct(ValidationException $validationException, Throwable $previous = null)
    {
        $this->errors = collect($validationException->getErrors());

        /** @var Error $error */
        $error = $this->errors->first();

        parent::__construct($error->getDescription(), Response::HTTP_BAD_REQUEST, $previous);
    }

    /**
     * @return Error[]
     */
    public function getErros()
    {
        return $this->errors;
    }
}
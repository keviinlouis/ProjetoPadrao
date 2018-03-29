<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 16:50
 */

namespace App\Moip\Exceptions;


use Illuminate\Http\Response;

class MoipIdException extends \Exception
{
    public function __construct($model)
    {
        $message = "Moip Id não existe na classe : ".get_class($model);
        $code = Response::HTTP_BAD_REQUEST;
        parent::__construct($message, $code);
    }
}
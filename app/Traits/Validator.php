<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 15/02/2018
 * Time: 02:45
 */

namespace App\Traits;


use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;

trait Validator
{
    use ValidatesRequests;

    /**
     * @param Collection|array|null $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @throws ValidationException
     * @return Collection
     */
    public function validateWithArray($data, array $rules, array $messages = [], array $customAttributes = []) : Collection
    {
        if(is_null($data)){
            return collect([]);
        }
        $validator = \Validator::make($data instanceof Collection ? $data->toArray() : $data, $rules, $messages, $customAttributes);
        return collect($this->validateWith($validator));
    }
}
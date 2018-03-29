<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class RuleCpfCnpj implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->validaCPF($value) || $this->validaCNPJ($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esse CPF ou CNPJ não é válido';
    }

    function validaCPF($cpf) {
        $validator = Validator::make(["cpf" => $cpf], ["cpf" => "cpf"]);

        return $validator->passes();
    }

    function validaCNPJ($cpf) {
        $validator = Validator::make(["cnpj" => $cpf], ["cnpj" => "cnpj"]);

        return $validator->passes();
    }
}

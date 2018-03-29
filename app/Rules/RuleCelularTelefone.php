<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class RuleCelularTelefone implements Rule
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
        return $this->validaCelular($value) || $this->validaTelefone($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esse Telefone ou Celular não é válido';
    }

    function validaCelular($celular) {
        $validator = Validator::make(["celular" => $celular], ["celular" => "celular_com_ddd"]);

        return $validator->passes();
    }

    function validaTelefone($telefone) {
        $validator = Validator::make(["telefone" => $telefone], ["telefone" => "telefone_com_ddd"]);

        return $validator->passes();
    }
}
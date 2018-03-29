<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RuleDataHoraMaiorQueAgora implements Rule
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
        $data = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $value);

        return $data->greaterThanOrEqualTo(now());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A data do lembrete deve ser maior ou igual a data atual';
    }
}

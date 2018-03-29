<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 31/01/2018
 * Time: 13:54
 */

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;


/**
 * Class RuleNomeCompleto
 * @package App\Rules
 */
class RuleNomeCompleto implements Rule
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
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nome do cartão precisa ser completo';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $nomes = explode(' ', $value);
        return count($nomes)>1;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 22/01/2018
 * Time: 13:53
 */

namespace App\Moip\Traits;


/**
 * Trait AttributesMasks
 * @package App\Moip\Traits
 */
trait AttributesMasks
{
    /**
     * @param $cpf
     * @return mixed
     */
    protected function clearCpf($cpf)
    {
        return $this->removeMask($cpf);
    }

    /**
     * @param $cep
     * @return mixed
     */
    protected function clearCep($cep)
    {
        return $this->removeMask($cep);
    }

    /**
     * @param $cnpj
     * @return mixed
     */
    protected function clearCnpj($cnpj)
    {
        return $this->removeMask($cnpj);
    }

    /**
     * @param $telefone
     * @return mixed
     */
    protected function clearPhone($telefone)
    {
        return $this->removeMask($telefone);
    }

    /**
     * @param $string
     * @param array $itens
     * @return mixed
     */
    protected function removeMask($string, $itens = ['-', '.', '%', '$', ',', '/', '(', ')', ' '])
    {
        foreach ($itens as $item) {
            $string = str_replace($item, '', $string);
        }
        return $string;
    }

    /**
     * @param $cpf
     * @return mixed
     */
    protected function makeMaskCpf($cpf)
    {
        return $this->makeMask($cpf,'###.###.###-##');
    }

    /**
     * @param $cep
     * @return mixed
     */
    protected function makeMaskCep($cep)
    {
        return $this->makeMask($cep,'#####-###');
    }

    /**
     * @param $cnpj
     * @return mixed
     */
    protected function makeMaskCnpj($cnpj)
    {
        return $this->makeMask($cnpj,'##.###.###/####-##');
    }

    /**
     * @param $telefone
     * @return mixed
     */
    protected function makeMaskPhone($telefone)
    {
        return $this->makeMask($telefone, '(##) ####-####');
    }

    /**
     * @param $telefone
     * @return mixed
     */
    protected function makeMaskCellPhone($telefone)
    {
        return $this->makeMask($telefone, '(##) ####-#####');
    }

    /**
     * @param $val
     * @param $mask
     * @return mixed
     */
    protected function makeMask($val, $mask)
    {
        $val = str_replace(" ","",$val);
        $maskared = $mask;
        for($i=0;$i<strlen($val);$i++){
            $maskared[strpos($maskared,"#")] = $val[$i];
        }
        return $maskared;
    }
}
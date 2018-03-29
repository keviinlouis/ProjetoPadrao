<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:06
 */

namespace App\Moip\Resources;


use App\Moip\Traits\AttributesMasks;

/**
 * Class Resource
 * @package App\Moip\Resources
 */
class Resource
{
    use AttributesMasks;

    /**
     * @param $phone
     * @return bool|string
     */
    public function codigoArea($phone)
    {
        return substr($this->clearPhone($phone), 0, 2);
    }

    /**
     * @param $phone
     * @return bool|string
     */
    public function telefoneSemArea($phone)
    {
        return substr($this->clearPhone($phone), 2);
    }
}
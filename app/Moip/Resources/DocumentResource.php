<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:16
 */

namespace App\Moip\Resources;


/**
 * Class DocumentResource
 * @package App\Moip\Resources
 */
class DocumentResource extends Resource
{
    CONST CPF = 'CPF';
    CONST RG = 'RG';

    public $type;
    public $number;

    /**
     * DocumentResource constructor.
     * @param $type
     * @param $number
     */
    public function __construct($type, $number)
    {
        $this->type = $type;
        $this->number = $this->removeMask($number);
    }
}
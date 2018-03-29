<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:15
 */

namespace App\Moip\Resources;


/**
 * Class PhoneResource
 * @package App\Moip\Resources
 */
class PhoneResource extends Resource
{
    public $countryCode;
    public $areaCode;
    public $number;

    /**
     * PhoneResource constructor.
     * @param $phone
     * @param string $countryCode
     */
    public function __construct($phone, $countryCode = '55')
    {
        $this->areaCode = $this->codigoArea($phone);
        $this->number = $this->telefoneSemArea($phone);
        $this->countryCode = $this->clearPhone($countryCode);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:14
 */

namespace App\Moip\Resources;


class AddressResource extends Resource
{
    CONST SHIPPING = 'SHIPPING';
    CONST BILLING = 'BILLING';

    public $type;
    public $street;
    public $streetNumber;
    public $district;
    public $city;
    public $state;
    public $zipCode;
    public $complement;
    public $country;

    /**
     * AddressResource constructor.
     * @param $type
     * @param $street
     * @param $streetNumber
     * @param $district
     * @param $city
     * @param $state
     * @param $zipCode
     * @param string $complement
     * @param string $country
     */
    public function __construct($type, $street, $streetNumber, $district, $city, $state, $zipCode, $complement = '', $country = 'BRA')
    {
        $this->type = $type;
        $this->city = $city;
        $this->complement = $complement;
        $this->district = $district;
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->zipCode = $this->clearCep($zipCode);
        $this->state = $state;
        $this->country = $country;
    }
}
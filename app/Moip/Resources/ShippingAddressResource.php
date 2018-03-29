<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:14
 */

namespace App\Moip\Resources;


class ShippingAddressResource extends AddressResource
{
    public function __construct($street, $streetNumber, $district, $city, $state, $zipCode, $complement = '', string $country = 'BRA')
    {
        parent::__construct(AddressResource::SHIPPING, $street, $streetNumber, $district, $city, $state, $zipCode, $complement, $country);
    }
}
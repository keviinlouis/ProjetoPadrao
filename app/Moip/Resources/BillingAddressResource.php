<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:14
 */

namespace App\Moip\Resources;


class BillingAddressResource extends AddressResource
{
    public function __construct($street, $streetNumber, $district, $city, $state, $zipCode, $complement = '', string $country = 'BRA')
    {
        $complement = is_null($complement)?'':$complement;
        parent::__construct(AddressResource::BILLING, $street, $streetNumber, $district, $city, $state, $zipCode, $complement, $country);
    }
}
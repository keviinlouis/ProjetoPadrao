<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 25/05/2018
 * Time: 22:51
 */

namespace App\Observers;


use App\Entities\Address;

class AddressObserver extends Observer
{
    public function saving(Address $address)
    {
        if($address->hasLatLong() && !$address->hasDadosAddresss()){
            $address->updateAddressByLatLong();
        }
    }
    /**
     * @param Address $address
     */
    public function saved(Address $address)
    {
        if(!$address->hasLatLong() || $this->isNotEqual(['cep', 'rua', 'numero', 'cidade', 'estado', 'bairro'], $address)){
            $address->loadLatLong();
        }
    }
}

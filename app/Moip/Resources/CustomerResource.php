<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:06
 */

namespace App\Moip\Resources;


use Carbon\Carbon;

/**
 * Class CustomerResource
 * @package App\Moip\Resources
 */
class CustomerResource extends Resource
{
    /**
     * @var $moipId
     * @var $ownId
     * @var $fullName
     * @var $email
     * @var DocumentResource $taxDocument
     * @var PhoneResource $phone
     * @var ShippingAddressResource $shippingAddress
     * @var BillingAddressResource $billingAddress
     */
    public $moipId;
    public $ownId;
    public $fullName;
    public $email;
    public $taxDocument;
    public $phone;
    public $shippingAddress;
    public $billingAddress;

    /**
     * CustomerResource constructor.
     * @param $moipId
     * @param $ownId
     * @param $fullName
     * @param $email
     * @param DocumentResource $taxDocument
     * @param PhoneResource $phone
     * @param ShippingAddressResource $shippingAddress
     */
    public function __construct($ownId, $fullName, $email, DocumentResource $taxDocument, PhoneResource $phone, ShippingAddressResource $shippingAddress = null, $moipId = null)
    {
        $this->moipId = $moipId;
        $this->ownId = $ownId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->taxDocument = $taxDocument;
        $this->phone = $phone;
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return bool
     */
    public function hasMoipId(){
        return !is_null($this->moipId);
    }

    /**
     * @return bool
     */
    public function hasShippingAddress(){
        return !is_null($this->shippingAddress);
    }

    /**
     * @return bool
     */
    public function hasBillingAddress(){
        return !is_null($this->billingAddress);
    }




}
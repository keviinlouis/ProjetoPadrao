<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 16:38
 */

namespace App\Moip\Resources;

use App\Moip\Traits\AttributesMasks;
use Couchbase\Document;


/**
 * Class HolderResource
 * @package App\Moip\Resources
 */
class HolderResource extends Resource
{
    public $fullName;
    public $birthDate;
    public $billingAddress;
    public $phone;
    public $document;

    /**
     * HolderResource constructor.
     * @param $fullName
     * @param $birthDate
     * @param DocumentResource $documentResource
     * @param PhoneResource $phone
     * @param BillingAddressResource $billingAddressResource
     */
    public function __construct($fullName, $birthDate, DocumentResource $documentResource, PhoneResource $phone, BillingAddressResource $billingAddressResource)
    {
        $this->fullName = $fullName;
        $this->birthDate = $birthDate;
        $this->billingAddress = $billingAddressResource;
        $this->document = $documentResource;
        $this->phone = $phone;
    }


}
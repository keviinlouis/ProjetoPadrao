<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:06
 */

namespace App\Moip\Resources;


class OrderResource extends Resource
{
    /**
     * @var $products ProductResource[]
     */
    public $moipId;
    public $ownId;
    public $currency;
    public $shipping;
    public $products;
    public $customer;

    /**
     * OrderResource constructor.
     * @param $ownId
     * @param float $shipping
     * @param ProductResource[] $products
     * @param CustomerResource $customer
     * @param string $currency
     */
    public function __construct($ownId,  Array $products, CustomerResource $customer, float $shipping = 0, string $currency = 'BRL')
    {
        $this->ownId = $ownId;
        $this->currency = $currency;
        $this->shipping = intval($shipping*100);
        $this->products = $products;
        $this->customer = $customer;
    }


}
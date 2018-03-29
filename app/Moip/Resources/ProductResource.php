<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 17:03
 */

namespace App\Moip\Resources;


/**
 * Class ProductResource
 * @package App\Moip\Resources
 */
class ProductResource extends Resource
{
    public $name;
    public $category;
    public $quantity;
    public $detail;
    public $price;

    /**
     * ProductResource constructor.
     * @param $name
     * @param $category
     * @param $quantity
     * @param $detail
     * @param $price
     */
    public function __construct($name, $quantity, $detail, $price, $category = '')
    {
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->detail = $detail;
        $this->price = intval($price*100);
    }


}
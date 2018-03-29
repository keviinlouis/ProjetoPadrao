<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:06
 */

namespace App\Moip\Resources;

/**
 * Class CreditCardResource
 * @package App\Moip\Resources
 */
class CreditCardResource extends Resource
{
    /**
     * @var HolderResource $holder
     * @var DocumentResource $taxDocument
     * @var PhoneResource $phone
     * @var $hash
     */
    public $holder;
    public $hash;
    public $moipId;
    public $parcelas;

    /**
     * CreditCardResource constructor.
     * @param HolderResource $holder
     * @param $parcelas
     * @param $hash
     */
    public function __construct(HolderResource $holder, $parcelas, $hash)
    {
        $this->holder = $holder;

        $this->hash = $hash;

        $this->parcelas = $parcelas;
    }

    /**
     * @return bool
     */
    public function hasMoipId(){
        return !is_null($this->moipId);
    }

}

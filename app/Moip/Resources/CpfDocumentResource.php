<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 16:06
 */

namespace App\Moip\Resources;


/**
 * Class CpfDocumentResource
 * @package App\Moip\Resources
 */
class CpfDocumentResource extends DocumentResource
{
    /**
     * CpfDocumentResource constructor.
     * @param $number
     */
    public function __construct($number)
    {
        parent::__construct(DocumentResource::CPF, $this->clearCpf($number));
    }
}
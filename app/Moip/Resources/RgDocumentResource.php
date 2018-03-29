<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 16:06
 */

namespace App\Moip\Resources;


class RgDocumentResource extends DocumentResource
{
    public function __construct($number)
    {
        parent::__construct(DocumentResource::RG, $number);
    }
}
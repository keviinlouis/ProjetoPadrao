<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 14/02/2018
 * Time: 20:50
 */

namespace App\Services;

use App\Traits\Validator;

abstract class Service
{
    use Validator;

    public $relations = [];

    public $relationsCount = [];

}
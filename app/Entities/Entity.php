<?php

namespace App\Entities;

use App\Traits\AttributesMasks;
use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    use AttributesMasks;
}
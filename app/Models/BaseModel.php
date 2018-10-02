<?php

namespace App\Models;

use App\Traits\AttributesMasks;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use AttributesMasks;
}

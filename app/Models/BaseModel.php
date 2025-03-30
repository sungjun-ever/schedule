<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    
    public function toArray(): array
    {
        $attributes = parent::toArray();
        $camelCaseAttributes = [];

        foreach ($attributes as $key => $value) {
            $camelCaseAttributes[Str::camel($key)] = $value;
        }

        return $camelCaseAttributes;
    }
    
}

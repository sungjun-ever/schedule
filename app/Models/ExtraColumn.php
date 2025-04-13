<?php

namespace App\Models;


class ExtraColumn extends BaseModel
{
    protected $fillable = [
        'column_name',
        'column_type',
        'lables'
    ];

    protected $softDeletes = true;
    
}

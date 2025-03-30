<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraColumn extends Model
{
    protected $fillable = [
        'column_name',
        'column_type',
        'lables'
    ];

    protected $softDeletes = true;
    
}

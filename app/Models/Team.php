<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends BaseModel
{
    protected $fillable = [
        'team_name',
        'description',
    ];

    protected $softDeletes = true;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

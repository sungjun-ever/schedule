<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
class ScheduleStatus extends BaseModel
{
    protected $table = 'schedule_status';

    protected $fillable = [
        'status_name',
        'status_background',
        'status_text_color',
    ];
    
    protected $softDeletes = true;

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'status_id');
    }
}

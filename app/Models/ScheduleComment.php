<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleComment extends BaseModel
{
    protected $fillable = [
        'schedule_id',
        'author_id',
        'comment',
    ];

    protected $softDeletes = true;

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

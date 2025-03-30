<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Schedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'order',
        'parent_id',
        'author_id',
        'color',
        'pm_id',
        'status_id',
    ];

    protected $softDeletes = true;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'parent_id');
    }

    public function scheduleStatus(): BelongsTo
    {
        return $this->belongsTo(ScheduleStatus::class, 'status_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function pm(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pm_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ScheduleParticipant::class, 'schedule_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Schedule::class, 'parent_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ScheduleComment::class, 'schedule_id');
    }
    
}

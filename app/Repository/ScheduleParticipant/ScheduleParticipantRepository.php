<?php

namespace App\Repository\ScheduleParticipant;

use App\Models\ScheduleParticipant;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class ScheduleParticipantRepository extends BaseRepository implements ScheduleParticipantRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(ScheduleParticipant $model)
    {
        $this->model = $model;
    }

    public function getByScheduleId(int $scheduleId): Collection
    {
        return $this->model->where('schedule_id', $scheduleId)->get();
    }

    public function deleteByScheduleId(int $scheduleId): mixed
    {
        return $this->model->where('schedule_id', $scheduleId)->delete();
    }
}
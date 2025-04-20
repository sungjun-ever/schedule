<?php

namespace App\Repository\Schedule;

use App\Models\ScheduleStatus;
use App\Repository\BaseRepository;

class ScheduleScheduleStatusRepository extends BaseRepository implements ScheduleScheduleStatusRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(ScheduleStatus $model)
    {
        $this->model = $model;
    }
}
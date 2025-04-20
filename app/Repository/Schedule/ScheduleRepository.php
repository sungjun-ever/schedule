<?php

namespace App\Repository\Schedule;

use App\Models\Schedule;
use App\Repository\BaseRepository;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(Schedule $model)
    {
        $this->model = $model;
    }
}
<?php

namespace App\Repository\ScheduleComment;

use App\Models\ScheduleComment;
use App\Repository\BaseRepository;

class ScheduleCommentRepository extends BaseRepository implements ScheduleCommentRepositoryInterface
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(ScheduleComment $model)
    {
        $this->model = $model;
    }

    public function deleteByScheduleId($id): mixed
    {
        return $this->model->where('schedule_id', $id)->delete();
    }
}
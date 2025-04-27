<?php

namespace App\Repository\Schedule;

use App\Models\Schedule;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function find(int $id): ?Schedule
    {
        return $this->model->with([
            'participants',
            'comments',
            'children',
        ])
            ->findOrFail($id);
    }

    public function paginate(array $data, int $limit): LengthAwarePaginator
    {
        return $this->model->with([
            'participants',
            'comments',
            'children'
        ])
            ->where(function ($query) use ($data) {
                if (!empty($data['title'])) {
                    $query->where('title', 'like', '%' . $data['title'] . '%');
                }

                if (!empty($data['pmId'])) {
                    $query->where('pm_id', $data['pmId']);
                }

                if (!empty($data['statusId'])) {
                    $query->where('status_id', $data['statusId']);
                }
            })
            ->paginate($limit);
    }

    public function countSchedules()
    {
        return $this->model->count();
    }

    public function getOrderSplit(int $order, int $excludeId): Collection
    {
        return $this->model->where('order', '>=', $order)
            ->whereNotIn('id', $excludeId)
            ->get();
    }
}
<?php

namespace App\Repository\Schedule;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ScheduleRepositoryInterface
{
    public function countSchedules();
    public function paginate(array $data, int $limit): LengthAwarePaginator;
    public function getOrderSplit(int $order, int $excludeId):Collection;
}
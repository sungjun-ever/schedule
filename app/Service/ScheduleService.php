<?php

namespace App\Service;

use App\DTOs\DtoInterface;
use App\Exceptions\CreateResourceFailedException;
use App\Models\Schedule;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Repository\Schedule\ScheduleScheduleStatusRepositoryInterface;

class ScheduleService
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(
        private readonly ScheduleRepositoryInterface $scheduleRepository,
        private readonly ScheduleScheduleStatusRepositoryInterface $scheduleStatusRepository
    )
    {
        //
    }

    public function create(DtoInterface $dto): int
    {
        $order = 1;
        $create = $this->scheduleRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
            'order' => $order,
            'parent_id' => $dto->parentId,
            'author_id' => $dto->authorId,
            'color' => $dto->color,
            'pm_id' => $dto->pmId,
            'status_id' => $dto->statusId,
        ]);

        if (!$create) {
            throw new CreateResourceFailedException('일정 등록 실패');
        }

        return $create->id;
    }

    public function createStatus(DtoInterface $dto)
    {
        $create = $this->scheduleStatusRepository->create([
            'status_name' => $dto->statusName,
            'status_background' => $dto->statusBackground,
            'status_text_color' => $dto->statusTextColor,
        ]);

        if (!$create) {
            throw new CreateResourceFailedException('일정 상태 등록 실패');
        }
    }

}
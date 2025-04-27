<?php

namespace App\Service;

use App\DTOs\Schedule\StoreScheduleDto;
use App\DTOs\Schedule\StoreScheduleStatusDto;
use App\DTOs\Schedule\UpdateScheduleDto;
use App\Exceptions\CreateResourceFailedException;
use App\Exceptions\DeleteResourceFailedException;
use App\Exceptions\UpdateResourceFailedException;
use App\Models\Schedule;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Repository\ScheduleComment\ScheduleCommentRepository;
use App\Repository\ScheduleParticipant\ScheduleParticipantRepository;
use App\Repository\ScheduleStatus\ScheduleScheduleStatusRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(
        private readonly ScheduleRepositoryInterface               $scheduleRepository,
        private readonly ScheduleScheduleStatusRepositoryInterface $scheduleStatusRepository,
        private readonly ScheduleParticipantRepository             $scheduleParticipantRepository,
        private readonly ScheduleCommentRepository                 $scheduleCommentRepository,
    )
    {
    }

    /**
     * 일정 페이징
     * @param array $data
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getSchedules(array $data, int $limit = 10): LengthAwarePaginator
    {
        return $this->scheduleRepository->paginate([
            'title' => $data['title'],
            'pmId' => $data['pmId'],
            'statusId' => $data['statusId'],
        ], $limit);
    }

    /**
     * 일정 조회
     * @param int $id
     * @return Schedule
     */
    public function findById(int $id): Schedule
    {
        return $this->scheduleRepository->find($id);
    }

    /**
     * 일정 생성
     * @param StoreScheduleDto $dto
     * @return int
     */
    public function create(StoreScheduleDto $dto): int
    {
        $id = null;
        DB::transaction(function () use ($dto, &$id) {
            $order = $this->scheduleRepository->countSchedules() + 1;

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

            $id = $create->id;

            $this->createParticipants($dto->participants, $id);
        });

        return $id;
    }

    /**
     * 일정 수정
     * @param UpdateScheduleDto $dto
     * @param int $id
     * @return void
     */
    public function update(UpdateScheduleDto $dto, int $id)
    {
        DB::transaction(function () use ($dto, $id) {
            $update = $this->scheduleRepository->update($id, [
                'title' => $dto->title,
                'description' => $dto->description,
                'start_date' => $dto->startDate,
                'end_date' => $dto->endDate,
                'parent_id' => $dto->parentId,
                'color' => $dto->color,
                'pm_id' => $dto->pmId,
                'status_id' => $dto->statusId,
            ]);

            if (!$update) {
                throw new UpdateResourceFailedException("일정 id: {$id}, 수정 실패");
            }

            $this->updateParticipants($dto->participants, $id);
        });
    }

    /**
     * 일정 노출 순서 변경
     * @param int $order
     * @param int $id
     * @return void
     */
    public function updateOrder(int $order, int $id)
    {
        DB::transaction(function () use ($order, $id) {
            $updateOrderSchedules = $this->scheduleRepository->getOrderSplit($order, $id);

            if (count($updateOrderSchedules) > 0) {
                $updateOrderSchedules->each(function (Schedule $schedule) {
                    $updateOrder = $this->scheduleRepository->update($schedule->id, [
                        'order' => $schedule->order + 1
                    ]);

                    if (!$updateOrder) {
                        throw new UpdateResourceFailedException("일정 id:{$schedule->id}, 순서 수정 실패");
                    }
                });
            }

            $update = $this->scheduleRepository->update($id, [
                'order' => $order
            ]);

            if (!$update) {
                throw new UpdateResourceFailedException("일정 id:{$id}, 순서 수정 실패");
            }
        });
    }

    /**
     * 일정 삭제
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        DB::transaction(function () use ($id) {
            $delete = $this->scheduleRepository->delete($id);

            if (!$delete) {
                throw new DeleteResourceFailedException("일정 id:{$id}, 삭제 실패");
            }

            $deleteParticipants = $this->scheduleParticipantRepository->deleteByScheduleId($id);

            if (!$deleteParticipants) {
                throw new DeleteResourceFailedException("일정 id:{$id} 참여자, 삭제 실패");
            }

            $deleteComments = $this->scheduleCommentRepository->deleteByScheduleId($id);

            if (!$deleteComments) {
                throw new DeleteResourceFailedException("일정 id:{$id} 댓글, 삭제 실패");
            }
        });

    }

    /**
     * 일정 상태 생성
     * @param StoreScheduleStatusDto $dto
     * @return void
     * @throws CreateResourceFailedException
     */
    public function createStatus(StoreScheduleStatusDto $dto)
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

    /**
     * 일정 참여자 생성
     * @param array $participants
     * @param int $scheduleId
     * @return void
     * @throws CreateResourceFailedException
     */
    private function createParticipants(array $participants, int $scheduleId)
    {
        if (!empty($participants)) {
            foreach ($participants as $participant) {
                $createParticipant = $this->scheduleParticipantRepository->create([
                    'schedule_id' => $scheduleId,
                    'user_id' => $participant,
                ]);

                if (!$createParticipant) {
                    throw new CreateResourceFailedException('참여자 등록 실패');
                }
            }
        }
    }

    /**
     * 일정 참여자 수정
     * @param array $participants
     * @param int $scheduleId
     * @return void
     * @throws CreateResourceFailedException
     * @throws DeleteResourceFailedException
     */
    private function updateParticipants(array $participants, int $scheduleId)
    {
        if (!empty($participants)) {
            $insertedParticipants = $this->scheduleParticipantRepository->getByScheduleId($scheduleId);

            if (count($insertedParticipants) > 0) {
                $insertedParticipantsIdSet = $insertedParticipants->pluck('id');
                $participants = collect($participants);

                $deleteParticipants = $insertedParticipantsIdSet->diff($participants);
                $insertParticipants = $participants->diff($insertedParticipants);

                foreach ($deleteParticipants as $deleteParticipant) {
                    $delete = $this->scheduleParticipantRepository->delete($deleteParticipant);

                    if (!$delete) {
                        throw new DeleteResourceFailedException("참여자 id: {$deleteParticipant}, 삭제 실패");
                    }
                }

                $insertParticipants->each(function ($insertParticipant) use ($scheduleId) {
                    $create = $this->scheduleParticipantRepository->create([
                        'schedule_id' => $scheduleId,
                        'user_id' => $insertParticipant,
                    ]);

                    if (!$create) {
                        throw new CreateResourceFailedException('참여자 등록 실패');
                    }
                });
            }

        }
    }

}
<?php

namespace App\Repository\ScheduleParticipant;

interface ScheduleParticipantRepositoryInterface
{
    public function getByScheduleId(int $scheduleId);
    public function deleteByScheduleId(int $scheduleId);
}
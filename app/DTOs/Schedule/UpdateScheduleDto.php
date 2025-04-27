<?php

namespace App\DTOs\Schedule;

use App\DTOs\DtoInterface;

class UpdateScheduleDto implements DtoInterface
{

    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $startDate,
        public ?string $endDate,
        public ?int $parentId,
        public ?string $color,
        public ?int $pmId,
        public ?int $statusId,
        public ?array $participants,
    )
    {
    }

    public static function from(array $data): self
    {
        return new static(
            title: $data['title'],
            description: $data['description'],
            startDate: $data['startDate'],
            endDate: $data['endDate'],
            parentId: $data['parentId'],
            color: $data['color'] ?? '#3498db',
            pmId: $data['pmId'],
            statusId: $data['statusId'],
            participants: $data['participants'],
        );
    }
}
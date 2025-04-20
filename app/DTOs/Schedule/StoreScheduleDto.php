<?php

namespace App\DTOs\Schedule;

use App\DTOs\DtoInterface;

readonly class StoreScheduleDto implements DtoInterface
{

    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $startDate,
        public ?string $endDate,
        public ?int $parentId,
        public ?int $authorId,
        public ?string $color,
        public ?int $pmId,
        public ?int $statusId,
    )
    {
    }

    public static function from(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            startDate: $data['startDate'],
            endDate: $data['endDate'],
            parentId: $data['parentId'],
            authorId: $data['authorId'],
            color: $data['color'] ?? '#3498db',
            pmId: $data['pmId'],
            statusId: $data['statusId'],
        );
    }
}
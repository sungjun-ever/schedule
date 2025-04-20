<?php

namespace App\DTOs\Schedule;

use App\DTOs\DtoInterface;

readonly class StoreScheduleStatusDto implements DtoInterface
{
    public function __construct(
        public string $statusName,
        public ?string $statusBackground,
        public ?string $statusTextColor,
    )
    {
    }

    public static function from(array $data): self
    {
        return new self(
            statusName: $data['statusName'],
            statusBackground: $data['statusBackground'] ?? '#ecf0f1',
            statusTextColor: $data['statusTextColor'] ?? '#7f8c8d',
        );
    }
}
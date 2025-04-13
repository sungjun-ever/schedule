<?php

namespace App\DTOs\Team;

use App\DTOs\DtoInterface;

readonly class StoreTeamDto implements DtoInterface
{
    public function __construct(
        public string $teamName,
        public ?string $description,
    ){}

    public static function from(array $data): self
    {
        return new self(
            teamName: $data['teamName'],
            description: $data['description']
        );
    }
}
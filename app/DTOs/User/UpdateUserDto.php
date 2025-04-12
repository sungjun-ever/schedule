<?php

namespace App\DTOs\User;

use App\DTOs\DtoInterface;

readonly class UpdateUserDto implements DtoInterface
{

    public function __construct(
        public string $name,
        public string $email,
        public ?string $teamId,
    )
    {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            teamId: $data['teamId'],
        );
    }
}
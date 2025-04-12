<?php

namespace App\DTOs\User;

use App\DTOs\DtoInterface;

readonly class UpdateUserDto implements DtoInterface
{

    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $level = null,
        public ?string $teamId = null,
    )
    {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            level: $data['level'],
            teamId: $data['teamId'],
        );
    }
}
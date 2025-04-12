<?php

namespace App\DTOs\User;

use App\DTOs\DtoInterface;
use App\Enum\User\UserLevel;

readonly class StoreUserDto implements DtoInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $level = UserLevel::USER->value,
        public ?int $teamId = null,
    ){}

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            level: $data['level'],
            teamId: $data['teamId']
        );
    }
}
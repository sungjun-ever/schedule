<?php

namespace App\DTO\User;

use App\DTO\DtoInterface;

readonly class StoreUserDto implements DtoInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $teamId,
    ){}

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            teamId: $data['teamId']
        );
    }
}
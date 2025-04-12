<?php

namespace App\DTOs;

interface DtoInterface
{
    public static function from(array $data): self;
}
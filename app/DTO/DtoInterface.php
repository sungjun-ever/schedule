<?php

namespace App\DTO;

interface DtoInterface
{
    public static function from(array $data): self;
}
<?php

namespace App\Repository\User;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getMemberByTeam(int $id): ?Collection;
    public function getAll(): ?Collection;
}
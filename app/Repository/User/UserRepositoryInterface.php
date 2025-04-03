<?php

namespace App\Repository\User;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findMemberByTeam(int $id): ?Collection;
}
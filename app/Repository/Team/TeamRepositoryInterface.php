<?php

namespace App\Repository\Team;

interface TeamRepositoryInterface
{
    public function getAll();

    public function findWithMembersById(int $id);
}
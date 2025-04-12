<?php

namespace App\Repository\Team;

use App\Models\Team;
use App\Repository\BaseRepository;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        $this->model = $model;
    }
}
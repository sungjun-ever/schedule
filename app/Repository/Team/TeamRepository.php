<?php

namespace App\Repository\Team;

use App\Models\Team;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        $this->model = $model;
    }


    public function getAll(): Collection
    {
        return $this->model->withCount('users')
            ->orderBy('id', 'desc')->get();
    }

    public function findWithMembersById(int $id): Team
    {
        return $this->model->with('users')
            ->where('id', $id)->first();
    }
}
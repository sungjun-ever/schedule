<?php

namespace App\Service;

use App\DTOs\Team\StoreTeamDto;
use App\DTOs\Team\UpdateTeamDto;
use App\Exceptions\CreateTeamException;
use App\Exceptions\TeamNotFoundException;
use App\Models\Team;
use App\Repository\Team\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{

    public function __construct(
        private readonly TeamRepositoryInterface $teamRepository,
    )
    {
    }

    public function getAllTeams(): Collection
    {
        return $this->teamRepository->getAll();
    }

    public function storeTeam(StoreTeamDto $dto): void
    {
        $result = $this->teamRepository->create([
            'team_name' => $dto->teamName,
            'description' => $dto->description,
        ]);

        if (!$result) {
            throw new CreateTeamException();
        }
    }

    public function findTeamById(int $id): Team
    {
        $team = $this->teamRepository->find($id);

        if (!$team) {
            throw new TeamNotFoundException();
        }

        return $team;
    }

    public function updateTeam(int $id, UpdateTeamDto $dto): void
    {
        $this->teamRepository->update($id, [
            'team_name' => $dto->teamName,
            'description' => $dto->description,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\DTOs\Team\StoreTeamDto;
use App\DTOs\Team\UpdateTeamDto;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Team;
use App\Service\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function __construct(
        private readonly TeamService $teamService
    )
    {
    }

    public function index()
    {
        $teams = $this->teamService->getAllTeams();

        return response()->json([
            'message' => 'success',
            'data' => $teams,
        ]);
    }

    public function store(StoreTeamRequest $request): JsonResponse
    {
        $this->teamService->storeTeam(StoreTeamDto::from([
            'teamName' => $request->post('teamName'),
            'description' => $request->post('description') ?: null,
        ]));

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function show(int $teamId): JsonResponse
    {
        $team = $this->teamService->findTeamById($teamId);
        return response()->json([
            'message' => 'success',
            'data' => $team,
        ]);
    }

    public function update(UpdateTeamRequest $request, int $teamId): JsonResponse
    {
        $this->teamService->updateTeam($teamId, UpdateTeamDto::from([
            'teamName' => $request->post('teamName'),
            'description' => $request->post('description') ?: null,
        ]));

        return response()->json([
            'status' => 'success',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\DTOs\Schedule\StoreScheduleDto;
use App\DTOs\Schedule\StoreScheduleStatusDto;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\StoreScheduleStatusRequest;
use App\Models\ScheduleStatus;
use App\Service\ScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{

    public function __construct(
        private readonly ScheduleService $scheduleService
    )
    {
    }

    public function index(): JsonResponse
    {

    }

    public function store(StoreScheduleRequest $request): JsonResponse
    {
        $id = $this->scheduleService->create(StoreScheduleDto::from([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'startDate' => $request->post('startDate'),
            'endDate' => $request->post('endDate'),
            'parentId' => $request->post('parentId'),
            'authorId' => $request->post('authorId'),
            'color' => $request->post('color'),
            'pmId' => $request->post('pmId'),
            'statusId' => $request->post('statusId'),
        ]));

        return response()->json([
            'status' => 'success',
            'id' => $id
        ]);
    }

    public function storeStatus(StoreScheduleStatusRequest $request)
    {
        $this->scheduleService->createStatus(StoreScheduleStatusDto::from([
            'statusName' => $request->post('statusName'),
            'statusBackground' => $request->post('statusBackground'),
            'statusTextColor' => $request->post('statusTextColor'),
        ]));

        return response()->json([
            'status' => 'success'
        ]);
    }
}

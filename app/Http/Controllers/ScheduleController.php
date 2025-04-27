<?php

namespace App\Http\Controllers;

use App\DTOs\Schedule\StoreScheduleDto;
use App\DTOs\Schedule\StoreScheduleStatusDto;
use App\DTOs\Schedule\UpdateScheduleDto;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\StoreScheduleStatusRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
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

    public function index(Request $request): JsonResponse
    {
        $limit = $request->query('limit', 10);
        $result = $this->scheduleService->getSchedules($limit);

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function show(int $scheduleId): JsonResponse
    {
        $result = $this->scheduleService->findById($scheduleId);

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
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
            'color' => $request->post('color', '#3498db'),
            'pmId' => $request->post('pmId'),
            'statusId' => $request->post('statusId'),
            'participants' => $request->post('participants', []),
        ]));

        return response()->json([
            'status' => 'success',
            'id' => $id
        ]);
    }

    public function update(UpdateScheduleRequest $request, int $scheduleId): JsonResponse
    {
        $this->scheduleService->update(UpdateScheduleDto::from([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'startDate' => $request->post('startDate'),
            'endDate' => $request->post('endDate'),
            'parentId' => $request->post('parentId'),
            'color' => $request->post('color', '#3498db'),
            'pmId' => $request->post('pmId'),
            'statusId' => $request->post('statusId'),
            'participants' => $request->post('participants', []),
        ]), $scheduleId);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function updateScheduleOrder(Request $request, int $scheduleId): JsonResponse
    {
        $this->scheduleService->updateOrder($request->post('order'), $scheduleId);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function delete(int $scheduleId): JsonResponse
    {
        $this->scheduleService->delete($scheduleId);

        return response()->json([
            'status' => 'success',
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

<?php

namespace App\Http\Controllers\Shifts;

use App\Http\Services\Shifts\ShiftService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Контроллер cvty.
 *
 * @package App\Http\Controllers
 */
final class ShiftsController extends Controller
{
    /**
     * Сервис.
     *
     * @var ShiftService
     */
    private ShiftService $service;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->service = new ShiftService;
    }

    /**
     * Получить список смен пользователей или всех пользователей если идентивикатор = 0.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
        $id = $request->input('id') ?? 0;
        $page = $request->input('page') ?? 1;
        [$shifts, $totalPages] = $this->service->getList($id, $page);
        return response()->json([
            'shifts' => $shifts,
            'totalPages' => $totalPages
        ], 200);
    }

    /**
     * Открыть смену
     * @param int $userId
     * @return JsonResponse
     */
    public function open(int $userId): JsonResponse
    {
        $this->service->open($userId);
        return response()->json(['title' => "Смена открыта"], 200);
    }

    /**
     * Закрыть смену
     * @param int $userId
     * @return JsonResponse
     */
    public function stop(int $userId): JsonResponse
    {
        $this->service->stop($userId);
        return response()->json(['title' => "Смена закрыта"], 200);
    }
}

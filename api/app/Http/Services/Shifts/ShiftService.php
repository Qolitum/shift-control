<?php

namespace App\Http\Services\Shifts;

use App\Http\Consts\Vocations;
use App\Models\Shift;

/**
 * Сервис пользователей.
 *
 * @package App\Services
 */
final class ShiftService
{
    /**
     * Получить пагинированный список смен или смены всех пользователей.
     *
     * @param int $id
     * @param int $page
     * @return array
     */
    public function getList(int $id, int $page): array
    {
        $query = Shift::query()->with('user:id,name,vocation');

        if ($id !== 0) {
            $query->where('user_id', $id);
        }

        $paginator = $query->orderByDesc('time_start')->paginate(perPage: 20, page: $page);

        $items = collect($paginator->items())
            ->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'time_start' => $item->time_start,
                    'time_end' => $item->time_end,
                    'user' => [
                        'name' => $item->user->name,
                        'vocation' => Vocations::VOCATIONS[$item->user->vocation] ?? $item->user->vocation
                    ]
                ];
            })
            ->toArray();

        return [
            $items,
            $paginator->lastPage(),
        ];
    }

    /**
     * Открыть рабочую смену.
     *
     * @param int $userId
     * @return void
     */
    public function open(int $userId): void
    {
        Shift::query()->
        create([
            'user_id' => $userId,
            'time_start' => now(),
            'time_end' => null,
        ]);
    }

    /**
     * Открыть рабочую смену.
     *
     * @param int $userId
     * @return void
     */
    public function stop(int $userId): void
    {
        Shift::query()
            ->where('user_id', $userId)
            ->whereNull('time_end')
            ->update([
            'time_end' => now(),
        ]);
    }
}

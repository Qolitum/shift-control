<?php

namespace App\Http\Services\Users;

use App\Http\Consts\Vocations;
use App\Models\User;

/**
 * Сервис пользователей.
 *
 * @package App\Services
 */
final class UserService
{
    /**
     * Получить список всех пользователей.
     *
     * @return User[]
     */
    public function getList(): array
    {
        return User::query()
            ->get()
            ->map(fn($user) => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'vocation' => Vocations::VOCATIONS[$user->vocation] ?? $user->vocation
            ])
            ->toArray();
    }

    /**
     * Создать пользователя.
     *
     * @param UserRequest $request
     *
     * @return void
     */
    public function create(UserRequest $request): void
    {
        $attributes = [
            'name' => $request->getName(),
            'vocation' => $request->getVocation(),
            'email' => $request->getEmail(),
            'password' => bcrypt($request->getPassword()),
        ];
        User::query()->create($attributes);
    }

    /**
     * Получить пользователя.
     *
     * @param string $userId
     *
     * @return array|null
     */
    public function getById(string $userId): ?array
    {
        $user = User::query()->find($userId);

        return $user ? [
            'id' => $user->id,
            'vocation' => $user->vocation,
            'email' => $user->email,
            'name' => $user->name,
        ] : null;
    }

    /**
     * Редактировать пользователя.
     *
     * @param int $id
     * @param UserRequest $request
     *
     * @return void
     */
    public function edit(int $id, UserRequest $request): void
    {
        $attributes = [
            'name' => $request->getName(),
            'vocation' => $request->getVocation(),
            'email' => $request->getEmail(),
        ];
        if ($request->getPassword()) {
            $attributes['password'] = bcrypt($request->getPassword());
        }
        User::query()
            ->whereKey($id)
            ->update($attributes);
    }

    /**
     * Удалить пользователя.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        User::query()->whereKey($id)->delete();
    }

    /**
     * Получить всех пользователей с информацией о рабочей смене.
     *
     * @return User[]
     */
    public function getUsersWithShifts(): array
    {
        return User::query()
            ->with(['shifts' => fn($query) => $query->whereNull('time_end')])
            ->get()
            ->map(fn($user) => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'vocation' => Vocations::VOCATIONS[$user->vocation] ?? $user->vocation,
                'has_active_shift' => $user->shifts->isNotEmpty()
            ])
            ->toArray();
    }
}

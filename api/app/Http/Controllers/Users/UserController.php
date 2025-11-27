<?php

namespace App\Http\Controllers\Users;

use App\Http\Services\Users\UserRequest;
use App\Http\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Контроллер пользователей.
 *
 * @package App\Http\Controllers
 */
final class UserController extends Controller
{
    /**
     * Сервис.
     *
     * @var UserService
     */
    private UserService $service;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->service = new UserService();
    }

    /**
     * Получить список пользователей.
     *
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        $users = $this->service->getList();
        return response()->json(['users' => $users], 200);
    }

    /**
     * Создать пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $creationRequest = new UserRequest(
            name: $request->input('name') ?? '',
            vocation: $request->input('vocation') ?? '',
            email: $request->input('email') ?? '',
            password: $request->input('password') ?? '',
        );
        $this->service->create($creationRequest);
        return response()->json(['title' => 'Изменения успешно сохранены'], 200);
    }

    /**
     * Получить пользователя.
     *
     * @param string $userId
     * @return JsonResponse
     */
    public function getById(string $userId): JsonResponse
    {
        $user = $this->service->getById($userId);
        if ($user === null) {
            return response()->json(['title' => 'Данного пользователя не существует'], 400);
        }
        return response()->json(['user' => $user], 200);
    }

    /**
     * Редактировать.
     *
     * @param string  $userId
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function edit(string $userId, Request $request): JsonResponse
    {
        $editingRequest = new UserRequest(
            name: $request->input('name') ?? '',
            vocation: $request->input('vocation') ?? '',
            email: $request->input('email') ?? '',
            password: $request->input('password') ?? '',
        );
        $this->service->edit($userId, $editingRequest);
        return response()->json(['title' => 'Изменения успешно сохранены'], 200);
    }

    /**
     * Удалить.
     *
     * @param string $userId
     * @return JsonResponse
     */
    public function delete(string $userId): JsonResponse
    {
        $this->service->delete($userId);
        return response()->json(['title' => 'Успешно удален'], 200);
    }

    /**
     * Получить всех пользователей с информацией о рабочей смене.
     * @return JsonResponse
     */
    public function getUsersWithShifts()
    {
        $users = $this->service->getUsersWithShifts();
        return response()->json(['users' => $users], 200);
    }
}

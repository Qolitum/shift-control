<?php

namespace App\Http\Services\Users;

/**
 * Запрос для работы с пользователем.
 *
 * @package App\Services\AdminPanel\Users
 */
final class UserRequest
{
    /**
     * Имя.
     *
     * @var string
     */
    private string $name;

    /**
     * Должность.
     *
     * @var string
     */
    private string $vocation;

    /**
     * Email.
     *
     * @var string
     */
    private string $email;

    /**
     * Пароль.
     *
     * @var string
     */
    private string $password;

    /**
     * Конструктор.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $name,
        string $vocation,
        string $email,
        string $password,
    ) {
        $this->name = $name;
        $this->vocation = $vocation;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Получить имя.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить олжность.
     *
     * @return string
     */
    public function getVocation(): string
    {
        return $this->vocation;
    }

    /**
     * Получить email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Получить имя.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}

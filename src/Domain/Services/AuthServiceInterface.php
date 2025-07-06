<?php

namespace Domain\Services;

interface AuthServiceInterface
{
    /**
     * Devuelve [ 'user' => User, 'token' => string ] o lanza ValidationException.
     */
    public function login(string $email, string $password): array;
}

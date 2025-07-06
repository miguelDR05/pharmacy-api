<?php

namespace Application\UseCases\Auth;

use Domain\Services\AuthServiceInterface;

class LoginUser
{
    public function __construct(private AuthServiceInterface $authService) {}

    public function execute(string $email, string $password): array
    {
        return $this->authService->login($email, $password);
    }
}

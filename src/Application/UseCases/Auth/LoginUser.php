<?php

namespace Application\Auth;

use Domain\Contracts\AuthRepositoryInterface;

class LoginUserUseCase
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function execute(string $email, string $password): array
    {
        return $this->authRepository->login($email, $password);
    }
}

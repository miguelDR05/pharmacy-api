<?php

namespace Infrastructure\Services;

use Domain\Services\AuthServiceInterface;
use Infrastructure\Persistence\Eloquent\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Importar la fachada Log
use Illuminate\Http\Request; // Importar Request para obtener la IP

class AuthService implements AuthServiceInterface
{
    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();
        $request = request(); // Obtener la instancia de Request

        if (!$user || !Hash::check($password, $user->password)) {
            Log::warning('Intento de login fallido: Credenciales incorrectas', [
                'email' => $email,
                'ip' => $request->ip() // Registrar la IP
            ]);
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas.'],
            ]);
        }

        if (!$user->active) {
            Log::warning('Intento de login fallido: Usuario inactivo', [
                'email' => $email,
                'ip' => $request->ip()
            ]);
            throw ValidationException::withMessages([
                'email' => ['Usuario inactivo.'],
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}

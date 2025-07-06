<?php

namespace Interface\Http\Controllers;

use Application\UseCases\Auth\LoginUser;
use Interface\Http\Requests\LoginRequest;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginUser $loginUser)
    {
        $result = $loginUser->execute($request->email, $request->password);

        return responseApi(
            code: 200,
            title: "Bienvenido",
            message: "Inicio de sesión exitoso",
            data: $result
        );
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }
}

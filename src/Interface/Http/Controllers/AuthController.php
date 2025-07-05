<?php

namespace Interface\Http\Controllers;

use App\Http\Controllers\Controller;

use Application\UseCases\Auth\RegisterUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request, RegisterUser $registerUser)
    {
        $user = $registerUser->handle($request->all());
        return response()->json(['message' => 'Usuario registrado', 'user' => $user], 201);
    }
}

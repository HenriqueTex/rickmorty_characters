<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            abort(401, 'Unauthorized');
        }

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}

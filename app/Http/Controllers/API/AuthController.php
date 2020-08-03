<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'document'       => 'required|string',
            'password'    => 'required|string',
        ]);
        $credentials = request(['document', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->respondHttp401("Credenciales Incorrectas");
        }
        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return $this->respondWithData([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )
                ->toDateTimeString(),
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->respondWithMessage('Successfully logged out');
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}

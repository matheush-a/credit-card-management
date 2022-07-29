<?php

namespace App\Http\Controllers;

use App\Lib\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected User $user;

    function __construct(User $user){
        $this->user = $user;
    }

    public function login(Request $request) {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $attempt = $this->user
            ->attempt($request
            ->only('email', 'password'));

        if(!$attempt) {
            return response()->json(
                ["message" => "Unauthenticated"],
                 Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $attempt->createToken('$request->token_name');

        return response()->json(
            $token->plainTextToken,
            Response::HTTP_OK
        );
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            "Token successfully deleted",
            Response::HTTP_NO_CONTENT
        );
    }
}
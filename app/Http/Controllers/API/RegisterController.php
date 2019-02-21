<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

/**
 * Registers a new User and generates a token.
 */
class RegisterController extends Controller
{
    /**
     * Handles actual registration.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create($data);
        $token = $user->createToken('Laravel Passport Grant Client')->accessToken;

        return response()->json([
            'message' => '',
            'token' => $token,
            'user' => $user,
        ], Response::HTTP_OK);
    }
}

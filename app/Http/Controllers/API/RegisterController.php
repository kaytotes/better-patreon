<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'password_confirmation' => 'required|string|min:6',
        ]);

        /* Create User and Passport Token */
        $user = User::create($data);
        $token = $user->createToken('Laravel Passport Grant Client')->accessToken;

        /* Fire Event */
        event(new Registered($user));

        return response()->json([
            'message' => __('auth.registration_complete'),
            'token' => $token,
            'user' => $user,
        ], Response::HTTP_OK);
    }
}

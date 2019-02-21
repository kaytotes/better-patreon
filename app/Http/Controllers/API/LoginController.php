<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Handles the login of a User, generating a token and returning it.
 */
class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::whereEmail($data['email'])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => __('auth.account_not_found'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Hash::check($data['password'], $user->password)) {
            $token = $user->createToken('Laravel Passport Grant Client')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => __('auth.invalid_password'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

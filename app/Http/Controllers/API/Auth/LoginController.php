<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Handles the login of a User, generating a token and returning it.
 */
class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        /* Find the User or Fail */
        try {
            $user = User::whereEmail($data['email'])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => __('auth.account_not_found'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /* Compare password hash and return token if matching */
        if (Hash::check($data['password'], $user->password)) {
            $token = $user->createToken('Laravel Passport Grant Client')->accessToken;

            return response()->json([
                'message' => __('auth.login_success'),
                'token' => $token,
                'user' => new UserResource($user),
            ], Response::HTTP_OK);
        }

        /* Otherwise must be an invalid password */
        return response()->json([
            'message' => __('auth.invalid_password'),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handles the Logout of a User.
 */
class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        info($request->all());
        
        $data = $request->validate([
            'all' => 'required|boolean',
        ]);

        info($data);

        /* If they're logged in then revoke access tokens */
        if (auth()->check()) {
            $request->user()->logout($data['all']);

            return response()->json([
                'message' => __('auth.logout_success'),
            ], Response::HTTP_OK);
        }

        /* Otherwise Return Error */
        return response()->json([
            'message' => __('auth.logout_fail'),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

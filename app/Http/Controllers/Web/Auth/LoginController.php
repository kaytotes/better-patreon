<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Simply displays the view for logging in.
 *
 * Actual Auth is handled in API\Auth.
 */
class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function __invoke(Request $request)
    {
        return view('auth.login');
    }
}

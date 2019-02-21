<?php

namespace App\Http\Controllers\Web\Base\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Displays the Home Page.
 */
class Home extends Controller
{
    public function __invoke(Request $request)
    {
        return view('base.home');
    }
}

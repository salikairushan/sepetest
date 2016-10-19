<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Utils\UserSession;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        UserSession::ResetSession($request);
        return redirect('/');
    }
}

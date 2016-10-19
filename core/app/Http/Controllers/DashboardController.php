<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 8/30/2016
 * Time: 10:28 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('UserSession');
        $this->middleware('remeberPreviousRoute');
    }
    public function viewDashboard(Request $request){
        return View::make('dashboard');
    }
}
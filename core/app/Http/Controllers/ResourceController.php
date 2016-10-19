<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class ResourceController extends Controller
{
    function __construct()
    {
        $this->middleware('UserSession');
        $this->middleware('remeberPreviousRoute');
    }
    /**
     * @return mixed
     */
    public function index(){
        return View::make('resource.index');
    }

    /**
     * @return Resource creation view.
     */
    public function create(){
        return View::make('resource.create');
    }

    /**
     * @param $id ID of requested Resource
     * @return Resource edit view.
     */
    public function edit(){
        return View::make('resource.edit');
    }
}

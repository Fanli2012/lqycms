<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
	
	public function index()
	{
		dd('wap/index');
	}
}

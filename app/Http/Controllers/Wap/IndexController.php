<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\CommonController;

class IndexController extends CommonController
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

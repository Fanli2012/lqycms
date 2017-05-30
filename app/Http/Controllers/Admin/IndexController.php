<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function index()
	{
		return view('admin.index.index');
	}
	
	//更新配置
	public function upconfig()
	{
        updateconfig();
    }
    
	//更新缓存
    public function upcache()
	{
		
    }
	
	//页面跳转
    public function jump()
	{
		return view('admin.index.jump');
    }
}

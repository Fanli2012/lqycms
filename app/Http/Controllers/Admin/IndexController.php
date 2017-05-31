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
        cache()->forget('sysconfig'); //删除缓存
		success_jump('更新成功！', route('admin_sysconfig'));
    }
    
	//更新缓存
    public function upcache()
	{
		cache()->forget('sysconfig'); //删除缓存
		success_jump('更新成功！', route('admin_sysconfig'));
    }
}

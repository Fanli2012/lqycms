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
		$data['menus'] = category_tree(get_category('menu',0));
		
		if($_SESSION['admin_user_info']['role_id']==1)
		{
			
		}
		else
		{
			
		}
		
		return view('admin.index.index', $data);
	}
	
	//更新配置
	public function upconfig()
	{
        cache()->forget('sysconfig'); //删除缓存
		success_jump('更新成功！');
    }
    
	//更新缓存
    public function upcache()
	{
		cache()->forget('sysconfig'); //删除缓存
		dir_delete(storage_path().'/framework/cache/data/');
		success_jump('更新成功！');
    }
}

<?php
namespace App\Http\Controllers\Admin;

use DB;

class GuestbookController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
		$res = '';
		$where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('title', 'like', '%'.$_REQUEST['keyword'].'%');
			}
        };
		
        $data['posts'] = parent::pageList('guestbook', $where);
		
		return view('admin.guestbook.index', $data);
    }
    
    public function edit()
    {
		$data['post'] = object_to_array(DB::table('guestbook')->where('id', 1)->first());
        
        return view('admin.guestbook.edit', $data);
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump("删除失败！请重新提交");}
		
		if(DB::table("guestbook")->whereIn("id", explode(',', $id))->delete())
        {
            success_jump("$id ,删除成功");
        }
		else
		{
			error_jump("$id ,删除失败！请重新提交");
		}
    }
}
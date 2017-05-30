<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class CommonController extends Controller
{
	public $user_info;
	
    public function __construct()
    {
        parent::__construct();
		
		if(isset($_SESSION['admin_user_info']))
		{
			$this->user_info = $_SESSION['admin_user_info'];
		}
        else
        {
            header("Location:".route('page404'));
			exit();
        }
    }
	
    /**
     * 获取分页数据及分页导航
     * @param string $modelname 模块名与数据库表名对应
     * @param array  $map       查询条件
     * @param string $orderby   查询排序
     * @param string $field     要返回数据的字段
     * @param int    $listRows  每页数量，默认10条
     * 
     * @return 格式化后输出的数据。内容格式为：
     *     - "code"                 (string)：代码
     *     - "info"                 (string)：信息提示
     * 
     *     - "result" array
     * 
     *     - "img_list"             (array) ：图片队列，默认8张
     *     - "img_title"            (string)：车图名称
     *     - "img_url"              (string)：车图片url地址
     *     - "car_name"             (string)：车名称
     */
    public function pageList($modelname, $map = '', $orderby = '', $field = '', $listRows = 15)
    {
        $orderby = !empty($orderby) ? $orderby : $orderby = ['id', 'desc'];
        
		// 查询满足的数据，并且每页显示15条数据
		$voList = DB::table($modelname)->where($map)->orderBy($orderby[0], $orderby[1])->paginate($listRows);
		
        return $voList;
    }
}

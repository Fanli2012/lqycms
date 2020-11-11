<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public $admin_info;

    public function __construct()
    {
        parent::__construct();

		// 添加管理员操作记录
		$this->operation_log_add();
    }

    /**
     * 获取分页数据及分页导航
     * @param string $modelname 模块名与数据库表名对应
     * @param array $where 查询条件
     * @param string $orderby 查询排序
     * @param string $field 要返回数据的字段
     * @param int $listRows 每页数量，默认30条
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
    public function pageList($modelname, $where = '', $orderby = '', $field = '*', $listRows = 30)
    {
        $model = \DB::table($modelname);

        //查询条件
        if (!empty($where)) {
            $model = $model->where($where);
        }

        //排序
        if ($orderby != '') {
            if ($orderby == 'rand()') {
                $model = $model->orderBy(\DB::raw('rand()'));
            } else {
                if (count($orderby) == count($orderby, 1)) {
                    $model = $model->orderBy($orderby[0], $orderby[1]);
                } else {
                    foreach ($orderby as $row) {
                        $model = $model->orderBy($row[0], $row[1]);
                    }
                }
            }
        } else {
            $model = $model->orderBy('id', 'desc');
        }

        //要返回的字段
        if ($field != '*') {
            $model = $model->select(\DB::raw($field));
        }

        return $model->paginate($listRows);
    }

	// 添加管理员操作记录
	public function operation_log_add()
    {
		$time = time();
		// 记录操作
        if ($this->admin_info) {
            $data['login_id'] = $this->admin_info['id'];
            $data['login_name'] = $this->admin_info['name'];
        }
        $data['type'] = 1;
        $data['ip'] = request()->ip();
        $data['url'] = mb_strcut(request()->url(), 0, 255, 'UTF-8');
        $data['http_method'] = request()->method();
        $data['domain_name'] = mb_strcut($_SERVER['SERVER_NAME'], 0, 60, 'UTF-8');
        if ($data['http_method'] != 'GET') { $data['content'] = mb_strcut(json_encode(request()->toArray(), JSON_UNESCAPED_SLASHES), 0, 255, 'UTF-8'); }
		if (!empty($_SERVER['HTTP_REFERER'])) { $data['http_referer'] = mb_strcut($_SERVER['HTTP_REFERER'], 0, 255, 'UTF-8'); }
        $data['add_time'] = $time;
        logic('Log')->add($data);
    }
}

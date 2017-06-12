<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = 'menu';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
	/**
     * 文件上传
     * @param $field
     * @return string
     */
    public function uploadImg($field)
    {
        if (Request::hasFile($field)) {
            $pic = Request::file($field);
            if ($pic->isValid()) {
                $newName = md5(rand(1, 1000) . $pic->getClientOriginalName()) . "." . $pic->getClientOriginalExtension();
                $pic->move('uploads', $newName);
                return $newName;
            }
        }
        return '';
    }
	
	//获取后台管理员所具有权限的菜单列表
	public static function getPermissionsMenu($role_id, $pid=0, $pad=0)
	{
		$res = [];
		
		$where['access.role_id'] = $role_id;
		$where['menu.pid'] = $pid;
		$where["menu.status"] = 1;
		
		$menu = object_to_array(\DB::table('menu')
            ->join('access', 'access.menu_id', '=', 'menu.id')
            ->select('menu.*', 'access.role_id')
			->where($where)
			->orderBy('listorder', 'asc')
            ->get());
		
		if($menu)
		{
			foreach($menu as $row)
			{
				$row['deep'] = $pad;
				
				if($PermissionsMenu = self::getPermissionsMenu($role_id, $row['id'], $pad+1))
				{
					$row['child'] = $PermissionsMenu;
				}
				
				$res[] = $row;
			}
		}
		
		return $res;
	}
}
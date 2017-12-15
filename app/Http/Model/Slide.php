<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Slide extends Model
{
    //轮播图
    
	protected $table = 'slide';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
    const UN_SHOW      = 1; // 不显示
    const IS_SHOW      = 0; // 显示
    
    public static function getList(array $param)
    {
        extract($param); //参数：group_id，limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $where['is_show'] = self::IS_SHOW;
        $model = new Slide;
        
        if(isset($group_id)){$where['group_id'] = $group_id;}
        
        if($where){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->orderBy('id', 'desc')->skip($offset)->take($limit)->get()->toArray();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($id)
    {
        return self::where('id', $id)->first()->toArray();
    }
    
    public static function add(array $data)
    {
        if ($id = DB::table(self::$table)->insertGetId($data))
        {
            return $id;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        $slide = DB::table(self::$table);
        if ($slide->where($where)->update($data))
        {
            return true;
        }
        
        return false;
    }
    
    //删除一条记录
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
    
    //获取显示平台文字：0pc，1weixin，2app，3wap
    public static function getTypeText($where)
    {
        $res = '';
        if($where['type'] === 0)
        {
            $res = 'pc';
        }
        elseif($where['type'] === 1)
        {
            $res = 'weixin';
        }
        elseif($where['type'] === 2)
        {
            $res = 'app';
        }
        elseif($where['type'] === 3)
        {
            $res = 'wap';
        }
        
        return $res;
    }
}
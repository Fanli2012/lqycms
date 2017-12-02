<?php
namespace App\Http\Model;
use App\Common\ReturnData;
use DB;

class GoodsBrand extends BaseModel
{
	//商品品牌
	
	protected $table = 'goods_brand';
    public $timestamps = false;
	protected $guarded = array(); //$guarded包含你不想被赋值的字段数组。
    
    const UN_SHOW      = 1; // 不显示
    const IS_SHOW      = 0; // 显示
    
    public static function getList(array $param)
    {
        extract($param); //参数：group_id，limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $where['status'] = self::IS_SHOW;
        $model = new self;
        
        if($where){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->orderBy('listorder', 'asc')->skip($offset)->take($limit)->get();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne(array $where)
    {
        extract($where);
        
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        if ($id = self::insertGetId($data))
        {
            return $id;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        if (self::where($where)->update($data) !== false)
        {
            return true;
        }
        
        return false;
    }
    
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
}
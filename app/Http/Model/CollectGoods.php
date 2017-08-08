<?php
namespace App\Http\Model;

use App\Common\Token;

class CollectGoods extends BaseModel
{
	//商品收藏
	
    protected $table = 'collect_goods';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];
	
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $where['user_id'] = Token::$uid;
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new CollectGoods;
        
        if(isset($type)){$where['type'] = $type;}
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get()->toArray();
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
        if(self::where(array('user_id'=>$data['user_id'],'goods_id'=>$data['goods_id']))->first()){return '亲，您已经收藏啦！';}
        
        if ($id = self::insertGetId($data))
        {
            return true;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        if (self::where($where)->update($data))
        {
            return true;
        }
        
        return false;
    }
    
    //删除一条记录
    public static function remove(array $data)
    {
        if(!self::where(array('user_id'=>$data['user_id'],'goods_id'=>$data['goods_id']))->first()){return '商品未收藏';}
        
        if (!self::where(array('user_id'=>$data['user_id'],'goods_id'=>$data['goods_id']))->delete())
        {
            return false;
        }
        
        return true;
    }
}
<?php
namespace App\Http\Model;

class UserGoodsHistory extends BaseModel
{
	//用户优惠券
	
    protected $table = 'user_goods_history';
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
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new UserGoodsHistory;
        
        if(isset($user_id)){$where['user_id'] = $user_id;}
        if(isset($goods_id)){$where['goods_id'] = $goods_id;}
        
        if(isset($where)){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get();
            
            if($res['list'])
            {
                foreach($res['list'] as $k=>$v)
                {
                    $goods = Goods::getOne(array('id'=>$v['goods_id'],'field'=>array('id', 'typeid', 'tuijian', 'click', 'title', 'sn', 'price','litpic', 'pubdate', 'add_time', 'market_price', 'goods_number', 'sale', 'comments','promote_start_date','promote_price','promote_end_date','goods_img','spec','point')));
                    
                    $res['list'][$k]['goods'] = $goods;
                }
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne(array $param)
    {
        extract($param); //参数
        
        $where['id'] = $id;
        
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        if(self::where($data)->first()){return false;}
        
        if (!self::where($data)->first())
        {
            $data['add_time'] = time();
            
            return self::insertGetId($data);
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
    
    //删除一条记录
    public static function remove($id,$user_id)
    {
        if (self::whereIn('id', explode(',', $id))->where('user_id',$user_id)->delete() === false)
        {
            return false;
        }
        
        return true;
    }
    
    //清空我的足迹
    public static function clear($user_id)
    {
        if (self::where('user_id',$user_id)->delete() === false)
        {
            return false;
        }
        
        return true;
    }
}
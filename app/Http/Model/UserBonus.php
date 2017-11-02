<?php
namespace App\Http\Model;

class UserBonus extends BaseModel
{
	//用户优惠券
	
    protected $table = 'user_bonus';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
	
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $where['user_id'] = $user_id;
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new UserBonus;
        
        if(isset($status)){$where['status'] = $status;}
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $bonus_list = $model->skip($offset)->take($limit)->orderBy('id','desc')->get();
            foreach($bonus_list as $k=>$v)
            {
                $bonus_list[$k]->bonus = Bonus::where('id',$v->bonus_id)->first();
            }
            
            $res['list'] = $bonus_list;
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($where)
    {
        $res = self::where($where)->first();
        if($res){$res->bonus = Bonus::where('id',$res->bonus_id)->first();}
        
        return $res;
    }
    
    public static function add(array $data)
    {
        if(self::where(['bonus_id'=>$data['bonus_id'],'user_id'=>$data['user_id']])->first()){return '亲，您已获取！';}
        
        if ($id = self::insertGetId($data))
        {
            return $id;
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
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
}
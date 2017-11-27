<?php
namespace App\Http\Model;
use App\Common\ReturnData;
use DB;

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
        if(!Bonus::where(['id'=>$data['bonus_id']])->where('num',-1)->first() && !Bonus::where(['id'=>$data['bonus_id']])->where('num','>',0)->first())
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您来晚了啦，已被抢光了');
        }
        
        if(self::where(['bonus_id'=>$data['bonus_id'],'user_id'=>$data['user_id']])->first()){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'亲，您已获取！');}
        
        $data['get_time'] = time(); //优惠券获取时间
        if ($id = self::insertGetId($data))
        {
            DB::table('bonus')->where(array('id'=>$data['bonus_id']))->decrement('num', 1);
            
            return ReturnData::create(ReturnData::SUCCESS,$id);
        }
        
        return ReturnData::create(ReturnData::SYSTEM_FAIL);
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
    
    //商品结算时，获取优惠券列表
	public static function getAvailableBonusList(array $param)
    {
        extract($param);
        
        $where['user_bonus.user_id'] = $user_id;
        if(isset($status)){$where['bonus.status'] = 0;}
        
        $model = new UserBonus;
        if(isset($min_amount)){$model = $model->where('bonus.min_amount', '<=', $min_amount)->where('bonus.money', '<=', $min_amount);} //满多少使用
        if(isset($bonus_end_time)){$model = $model->where('bonus.end_time', '>=', date('Y-m-d H:i:s'));} //有效期
        
        $bonus_list = $model->join('bonus', 'bonus.id', '=', 'user_bonus.bonus_id')->where($where)
            ->select('bonus.*', 'user_bonus.user_id', 'user_bonus.used_time', 'user_bonus.get_time', 'user_bonus.status as user_bonus_status', 'user_bonus.id as user_bonus_id')
            ->orderBy('bonus.money','desc')->get();
        
		$res['list'] = $bonus_list;
        
        return $res;
    }
    
    public static function getUserBonusByid(array $param)
    {
        extract($param);
        
        $where['user_bonus.user_id'] = $user_id;
        $where['bonus.status'] = 0;
        $where['user_bonus.id'] = $user_bonus_id;
        
        $model = new UserBonus;
        if(isset($min_amount)){$model = $model->where('bonus.min_amount', '<=', $min_amount)->where('bonus.money', '<=', $min_amount);} //满多少使用
        $model = $model->where('bonus.end_time', '>=', date('Y-m-d H:i:s')); //有效期
        
        $bonus = $model->join('bonus', 'bonus.id', '=', 'user_bonus.bonus_id')->where($where)
            ->select('bonus.*', 'user_bonus.user_id', 'user_bonus.used_time', 'user_bonus.get_time', 'user_bonus.status as user_bonus_status', 'user_bonus.id as user_bonus_id')
            ->first();
        
        return $bonus;
    }
}
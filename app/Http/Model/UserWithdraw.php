<?php
namespace App\Http\Model;

use App\Common\Token;
use DB;
use App\Common\ReturnData;

class UserWithdraw extends BaseModel
{
	//用户余额明细
	
    protected $table = 'user_withdraw';
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
        $where['user_id'] = $user_id;
        $where['is_delete'] = 0;
        
        $model = new self;
        
        if(isset($status) && !empty($status)){if($status==-1){}else{$where['status'] = $status;}}
        if(isset($method)){$where['method'] = $method;}
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get();
            
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k]['status_text'] = self::getStatusText($v);
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
        extract($param);
        
        $where['id'] = $id;
        $where['is_delete'] = 0;
        
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        $user = User::where(array('id'=>$data['user_id'],'pay_password'=>$data['pay_password']))->first();
        if(!$user){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'支付密码错误');}
        unset($data['pay_password']);
        
        $min_withdraw_money = sysconfig('CMS_MIN_WITHDRAWAL_MONEY'); //最低可提现金额
        if($user['money']<$data['money']){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'余额不足');}
        if($user['money']<$min_withdraw_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'用户金额小于最小提现金额');}
        if($data['money']<$min_withdraw_money){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'提现金额不得小于最小提现金额');}
        
        if ($id = self::insertGetId($data))
        {
            //扣除用户余额
            DB::table('user')->where(array('id'=>$data['user_id']))->decrement('money', $data['money']);
            //增加用户余额记录
            DB::table('user_money')->insert(array('user_id'=>$data['user_id'],'type'=>1,'money'=>$data['money'],'des'=>'提现','user_money'=>DB::table('user')->where(array('id'=>$data['user_id']))->value('money'),'add_time'=>time()));
            
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
    public static function remove($id,$user_id)
    {
        if (!self::whereIn('id', explode(',', $id))->where('user_id',$user_id)->update(array('is_delete'=>1)))
        {
            return false;
        }
        
        return true;
    }
    
    //获取提现状态文字:0未处理,1处理中,2成功,3取消，4拒绝
    public static function getStatusText($where)
    {
        $res = '';
        if($where['status'] == 0)
        {
            $res = '未处理';
        }
        elseif($where['status'] == 1)
        {
            $res = '处理中';
        }
        elseif($where['status'] == 2)
        {
            $res = '成功';
        }
        elseif($where['status'] == 3)
        {
            $res = '取消';
        }
        elseif($where['status'] == 4)
        {
            $res = '拒绝';
        }
        
        return $res;
    }
}
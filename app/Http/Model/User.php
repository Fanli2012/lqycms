<?php
namespace App\Http\Model;

use App\Common\Token;

class User extends BaseModel
{
	//用户模型
	
    protected $table = 'user';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
	protected $hidden = array('password','pay_password');
    
	/**
     * 获取关联到用户的角色
     */
    public function userrole()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }
    
    //签到
	public static function signin()
    {
        $user = self::where(['id'=>Token::$uid])->first();
		
		$signin_time='';
		if(!empty($user->signin_time)){$signin_time = date('Ymd',strtotime($user->signin_time));} //签到时间
		
		$today = date('Ymd',time()); //今日日期
		
		if($signin_time==$today){return '今日已签到！';}
		
		$signin_point = (int)Sysconfig::where(['varname'=>'CMS_SIGN_POINT'])->value('value'); //签到积分
		User::where(['id'=>Token::$uid])->update(['point'=>($user->point+$signin_point),'signin_time'=>date('Y-m-d H:i:s')]); //更新用户积分，及签到时间
		UserPoint::insert(['type'=>1,'point'=>$signin_point,'des'=>'签到','user_id'=>Token::$uid]); //添加签到积分记录
		
		return true;
    }
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new User;
        
        if(isset($group_id)){$where['group_id'] = $group_id;}
        if(isset($parent_id)){$where['parent_id'] = $parent_id;}
        
        if(isset($where)){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list'] = $model->select('id','user_name','email','sex','money','commission','point','mobile','nickname','head_img','add_time')->skip($offset)->take($limit)->orderBy('id','desc')->get();
            
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k]['user_name'] = !empty($res['list'][$k]['mobile']) ? $res['list'][$k]['mobile'] : $res['list'][$k]['user_name'];
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    //获取一条用户信息
	public static function getOne($id)
    {
        $user = self::where('id', $id)->first();
        if(!$user){return false;}
        $user['reciever_address'] = UserAddress::getOne($user->address_id);
        
		return $user;
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
    
    //获取一条用户信息
	public static function getOneUser($where)
    {
        $user = self::where($where)->first();
        if(!$user){return false;}
        
		return $user;
    }
    
    //获取用户信息
    public static function getUserInfo($user_id)
    {
        $user = self::where('id', $user_id)->first();
        if(!$user){return false;}
        $user->reciever_address = UserAddress::getOne($user->address_id);
        $user->collect_goods_count = CollectGoods::where('user_id', $user_id)->count();
        $user->bonus_count = UserBonus::where(array('user_id'=>$user_id,'status'=>0))->count();
        
        $userinfo = $user->makeVisible(array('pay_password'))->toArray();
        $user->pay_password = 0;
        if($userinfo['pay_password']){$user->pay_password = 1;}

        return $user;
    }

    //修改用户密码、支付密码
    public static function userPasswordUpdate($where,array $param)
    {
        extract($param);
        $data = '';

        $user = self::where($where)->first();
        if(!$user){return false;}

        $user = $user->makeVisible(array('password','pay_password'))->toArray();

        if(isset($old_password) && $old_password!=$user['password']){return false;} //旧密码错误
        if(isset($password) && $password==''){return false;} //新密码为空

        if(isset($old_pay_password) && $old_pay_password!=$user['pay_password']){return false;}
        if(isset($pay_password) && $pay_password==''){return false;}

        if(isset($password)){$data['password'] = $password;}
        if(isset($pay_password)){$data['pay_password'] = $pay_password;}

        if ($data != '' && self::where($where)->update($data))
        {
            return true;
        }

        return false;
    }
    
    //注册
    public static function wxRegister(array $param)
	{
        extract($param); //参数
        
        if(isset($user_name)){$data['user_name'] = $user_name;}
        if(isset($mobile)){$data['mobile'] = $mobile;}
        if(isset($password)){$data['password'] = $password;} //md5加密
        if(isset($parent_id) && !empty($parent_id)){$data['parent_id'] = $parent_id;}
        if(isset($openid)){$data['openid'] = $openid;}
        if(isset($sex)){$data['sex'] = $sex;}
        if(isset($head_img)){$data['head_img'] = $head_img;}
        if(isset($nickname)){$data['nickname'] = $nickname;}
        
        if (isset($data) && $id = self::add($data))
        {
            //生成token
			return Token::getToken(Token::TYPE_WEIXIN, $id);
        }
        
        return false;
    }
    
    //用户登录
	public static function wxLogin(array $param)
    {
        extract($param); //参数
        
        if(isset($openid) && !empty($openid))
        {
            $user = self::where(array('openid'=>$openid))->first();
        }
        else
        {
            $user = self::where(array('mobile'=>$user_name,'password'=>$password))->orWhere(array('user_name'=>$user_name,'password'=>$password))->first();
        }
        
        if(!isset($user)){return false;}
        
        $res = self::getUserInfo($user->id);
        $token = Token::getToken(Token::TYPE_WEIXIN, $user->id);
        
        foreach($token as $k=>$v)
        {
            $res->$k = $v;
        }
        
		return $res;
    }
    
    //获取性别文字：0未知,1男,2女
    public static function getSexText($where)
    {
        $res = '';
        if($where['sex'] === 0)
        {
            $res = '未知';
        }
        elseif($where['sex'] === 1)
        {
            $res = '男';
        }
        elseif($where['sex'] === 2)
        {
            $res = '女';
        }
        
        return $res;
    }
    
    //获取用户状态文字：1正常 2 删除 3锁定
    public static function getStatusText($where)
    {
        $res = '';
        if($where['status'] === 1)
        {
            $res = '正常';
        }
        elseif($where['status'] === 2)
        {
            $res = '删除';
        }
        elseif($where['status'] === 3)
        {
            $res = '锁定';
        }
        
        return $res;
    }
}
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
    protected $guarded = [];
	
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
        
        $where = '';
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new User;
        
        if(isset($group_id)){$where['group_id'] = $group_id;}
        
        if($where != '')
        {
            $model = $model->where($where);
        }
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->select('id','user_name','email','sex','money','point','mobile','nickname','add_time')->skip($offset)->take($limit)->orderBy('id','desc')->get()->toArray();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    //用户信息
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
}
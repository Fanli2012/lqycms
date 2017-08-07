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
	public static function signin(array $param)
    {
        extract($param); //参数：limit，offset
        
        $user = self::where(['id'=>Token::$uid])->first();
		if($user){}else{return false;}
		
		$signin_time='';
		if(!empty($user->signin_time)){$signin_time = date('Ymd',strtotime($user->signin_time));} //签到时间
		
		$today = date('Ymd',time()); //今日日期
		
		if($signin_time==$today){return ReturnCode::create(101,'已经签到啦，请明天再来！');}
		
		$signin_point = (int)DB::table('system')->where(['keyword'=>'signin_point'])->value('value'); //签到积分
		DB::table('user')->where(['id'=>Token::$uid])->update(['point'=>($user->point+$signin_point),'signin_time'=>date('Y-m-d H:i:s')]); //更新用户积分，及签到时间
		DB::table('user_point_log')->insert(['type'=>1,'point'=>$signin_point,'des'=>'签到','user_id'=>Token::$uid]); //添加签到积分记录
		
		return ReturnCode::create(ReturnCode::SUCCESS,'恭喜您今日签到成功！+'.$signin_point.'积分');
        
        
        
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = self::where('user_id', Token::$uid);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->get()->toArray();
            
            if($res['list'])
            {
                foreach($res['list'] as $k=>$v)
                {
                    $res['list'][$k]['country_name']  = Region::getRegionName($v['country']);
                    $res['list'][$k]['province_name'] = Region::getRegionName($v['province']);
                    $res['list'][$k]['city_name']     = Region::getRegionName($v['city']);
                    $res['list'][$k]['district_name'] = Region::getRegionName($v['district']);
                }
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
}
